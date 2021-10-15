<?php

namespace App\Http\Controllers;

use App\Models\ArtColection;
use App\Models\ArtPainting;
use App\Rules\PrincipalPage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colections = ArtColection::orderBy('id', 'asc')->paginate(8);
        foreach ($colections as $colection) {
            $colection['paintings'] = ArtPainting::where('art_colection_id', '=', $colection->id)->limit(4)->get(); 
        }

        return view('Web/Art/painting/paint_index', ['colections' => $colections]);
    }

    /**
     * Display a listing of the resource for admin use.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_admin()
    {
        $paintings = ArtPainting::sortable()->paginate(15);

        return view('Admin/art/paint/paint_index_admin', ['paintings' => $paintings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colections = ArtColection::all();
        
        return view('Admin/art/paint/paint_create', ['colections' => $colections]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'art_colection_id' => 'required|numeric',
            'tecnique' => 'required|string|max:255',
            'width' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
            'description' => 'nullable|string|max:500'
        ]);
        if ($validator->fails()) {
            return redirect('/art/painting/create')
                        ->withErrors($validator)
                        ->withInput();
        }        
        $painting = ArtPainting::create($request->all());
        return redirect()->route('images_create_model', ['modelType' => 'paint', 'modelId' => $painting->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $painting = ArtPainting::find($id);
        if(!$painting){
            abort('404');
        }
        $colection = ArtPainting::where('art_colection_id', '=', $painting->colection->id)->limit(5)->get();
        
        return view('Web/Art/painting/paint_show', ['painting' => $painting, 'colection' => $colection]);
    }

    /**
     * Display the specified resource for admin use.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_admin($id)
    {
        $painting = ArtPainting::find($id);
        if(!$painting){
            return view('errors/model_not_found', ['modelName' => 'obra de arte']);
        }
        
        return view('Admin/art/paint/paint_show_admin', ['painting' => $painting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $painting = ArtPainting::find($id);
        if(!$painting){
            return view('errors/model_not_found', ['modelName' => 'obra de arte']);
        }
        $colections = ArtColection::all();
        
        return view('Admin/art/paint/paint_edit', ['painting' => $painting, 'colections' => $colections]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $painting = ArtPainting::find($id);
        if(!$painting){
            return view('errors/model_not_found', ['modelName' => 'obra de arte']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'art_colection_id' => 'required|numeric',
            'tecnique' => 'required|string|max:255',
            'width' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
            'description' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return redirect('/art/painting/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $painting->name = $request->get('name');
        $painting->art_colection_id = $request->get('art_colection_id');
        $painting->tecnique = $request->get('tecnique');
        $painting->width = $request->get('width');
        $painting->height = $request->get('height');
        $painting->description = $request->get('description');

        $painting->save();

        return redirect()->route('paint_show_admin', [$id])->with('success','hola');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        
        try {
            DB::beginTransaction();

            $painting = ArtPainting::find($request->get('id'));
            $locations = [];
            foreach ($painting->images as $image) {
                $locations[] = '/'.$image->location;
                if(!$image->delete()){
                    DB::rollBack();
                    return json_encode(['message' => 'Error al eliminar las imagenes']);
                }
            }

            if(!$painting->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar la obra de arte']);
            }
            
            if(!Storage::delete($locations)) {
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar los archivos']);
            }
            DB::commit();
        } catch(Exception $e){
            DB::rollback();
            $error = ([
                'message' => $e->getMessage()
            ]);
            json_encode($error);
            return ($error);
        }
        $success = (['message' => 'success']);

        return json_encode($success);
    }

    /**
     * Show a list of paintings of a determinary art colection
     * 
     * @param int $art_colection_id
     * @return \Illuminate\Http\Response
     */
    public function show_colection($art_colection_id) {
        $paintings = ArtPainting::where('art_colection_id', '=', $art_colection_id)->get();

        return view('Web/Art/painting/paint_colection_index', ['paintings' => $paintings]);
    }
}
