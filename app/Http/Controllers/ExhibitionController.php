<?php

namespace App\Http\Controllers;

use App\Models\ArtExhibition;
use App\Models\Location;
use App\Rules\PrincipalPage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ExhibitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actualExhibitions = ArtExhibition::where('date_start', '<=', now())->where('date_finish', '>=', now())->get();
        $futureExhibitions = ArtExhibition::where('date_start', '>', now())->get();
        $pastExhibitions = ArtExhibition::where('date_finish', '<', now())->orderBy('date_finish','desc')->paginate(4);

        return view('Web/Art/exhibition/exhibition_index', ['actualExhibitions' => $actualExhibitions, 'futureExhibitions' => $futureExhibitions, 'pastExhibitions' => $pastExhibitions]);
    }

    /**
     * Display a listing of the resource for admin use.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_admin()
    {
        $exhibitions = ArtExhibition::sortable(['date_start' => 'desc'])->paginate(15);

        return view('Admin/art/exhibitions/exhibition_index_admin', ['exhibitions' => $exhibitions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();

        return view('Admin/art/exhibitions/exhibition_create', ['locations' => $locations]);
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
            'title' => 'required|string|max:255',
            'location_id' => 'required|numeric',
            'date_start' => 'required|date',
            'date_finish' => 'required|date|after:date_start',
            'description' => 'required|string|max:500',
            'hour_start' => 'required|date_format:H:i',
            'hour_finish' => 'required|date_format:H:i',
            'principal_page' => ['sometimes',new PrincipalPage('exhibitions', 2)]
        ]);
        if ($validator->fails()) {
            return redirect('/art/exhibition/create/new')
                        ->withErrors($validator)
                        ->withInput();
        }
        $requestData = $request->all();        
        $requestData['principal_page'] = $request->has('principal_page') ? $request->get('principal_page') : false;
        $exhibition = ArtExhibition::create($requestData);
        return redirect()->route('images_create_model', ['modelType' => 'exhibitions', 'modelId' => $exhibition->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exhibition = ArtExhibition::find($id);

        if(!$exhibition) {
            abort('404');
        }
        
        return view('Web/Art/exhibition/exhibition_show', ['exhibition' => $exhibition]);
    }

    /**
     * Display the specified resource for admin use.
     *
     * @param  int  $id
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function show_admin($id)
    {
        $exhibition = ArtExhibition::find($id);

        if(!$exhibition) {
            return view('errors/model_not_found', ['modelName' => 'exhibicion']);
        }
        
        return view('Admin/art/exhibitions/exhibition_show_admin', ['exhibition' => $exhibition]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exhibition = ArtExhibition::find($id);

        if(!$exhibition) {
            return view('errors/model_not_found', ['modelName' => 'exhibicion']);
        }
        $locations = Location::all();

        return view('Admin/art/exhibitions/exhibition_edit', ['exhibition' => $exhibition, 'locations' => $locations]);
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
        $exhibition = ArtExhibition::find($id);

        if(!$exhibition) {
            return view('errors/model_not_found', ['modelName' => 'exhibicion']);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'location_id' => 'required|numeric',
            'date_start' => 'required|date',
            'date_finish' => 'required|date|after:date_start',
            'principal_page' => ['sometimes',new PrincipalPage('exhibitions', 2, $id)]
        ]);
        if ($validator->fails()) {
            return redirect('/art/exhibition/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }        
        $exhibition->title = $request->get('title');
        $exhibition->location_id = $request->get('location_id');
        $exhibition->date_start = $request->get('date_start');
        $exhibition->date_finish = $request->get('date_finish');
        $exhibition->principal_page = $request->has('principal_page') ? $request->get('principal_page') : false;

        $exhibition->save();

        return redirect()->route('exhibition_show_admin', [$id])->with('success','hola');
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

            $exhibition = ArtExhibition::find($request->get('id'));
            $locations = [];
            foreach ($exhibition->images as $image) {
                $locations[] = '/'.$image->location;
                if(!$image->delete()){
                    DB::rollBack();
                    return json_encode(['message' => 'Error al eliminar las imagenes']);
                }
            }

            if(!$exhibition->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar la exhibicion']);
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
}
