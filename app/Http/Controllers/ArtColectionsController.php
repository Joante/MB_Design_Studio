<?php

namespace App\Http\Controllers;

use App\Models\ArtColection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
use App\Models\Image as ModelsImage;
use App\Rules\PrincipalPage;
use Illuminate\Support\Facades\Storage;

class ArtColectionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colections = ArtColection::all();

        return view('Admin/art/paint/art_colections/art_colection_show_index_admin');
    }

    /**
     * Display a listing of the resource for admin use.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_admin()
    {
        $colections = ArtColection::sortable()->paginate(15);

        return view('Admin/art/paint/art_colections/art_colection_index_admin', ['colections' => $colections]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/art/paint/art_colections/art_colection_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'required|image|max:10240',
            'principal_page' => ['sometimes',new PrincipalPage('colections', 4)]
        ]);
        try{
            DB::beginTransaction();

            $newColection = [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'principal_page' => $request->get('principal_page')
            ];
            $colection = ArtColection::create($newColection);
            if(!$colection) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la coleccion'];
                return redirect('art/painting/colection/create')
                    ->withErrors($error)
                    ->withInput();
            }
            $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageTitle = $request->file('image')->getClientOriginalName();

            $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
            $imageName = $colection->id.'_'.$imageNameSave.'_'.time().'.'.$extension;
            
            $imagePath = 'img/art_colections/'.$imageName;
            $newImage = [
                'title' => $imageTitle,
                'location' => $imagePath
            ];
            
            if(!$colection->image()->create($newImage)) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen'];
                return redirect('art/painting/colection/create')
                    ->withErrors($error)
                    ->withInput();
            }

            if (!is_dir(public_path('/').'img/art_colections/')){
                mkdir(public_path('/').'img/art_colections/', 0770, true);
            }   
            Image::make($request->file('image'))->save(public_path('/').$imagePath);
            
            if (!file_exists(public_path('/').$imagePath)) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen'];
                return redirect('art/painting/colection/create')
                        ->withErrors($error)
                        ->withInput();
            }
            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            $error = ['error' => $e->getMessage()];
            return redirect('art/painting/colection/create')
                        ->withErrors($error)
                        ->withInput();
        }
        
        
        return redirect()->route('paint_colection_index_admin');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $colection = ArtColection::find($id);

        if(!$colection) {
            return view('errors/model_not_found', ['modelName' => 'coleccion de arte']);
        }
        
        return view('Admin/art/paint/art_colections/art_colection_show_admin', ['colection' => $colection]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $colection = ArtColection::find($id);

        if(!$colection) {
            return view('errors/model_not_found', ['modelName' => 'coleccion de arte']);
        }

        return view('Admin/art/paint/art_colections/art_colection_edit', ['colection' => $colection]);
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
        $colection = ArtColection::find($id);

        if(!$colection) {
            return view('errors/model_not_found', ['modelName' => 'coleccion de arte']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'nullable|image|max:10240',
            'principal_page' => ['sometimes',new PrincipalPage('colections', 4, $id)]
        ]);

        if($request->has('image'))
        {
            try{
                DB::beginTransaction();

                $location = $colection->image->location;
                
                if(!ModelsImage::destroy($colection->image->id)) {
                    DB::rollBack();
                    return json_encode('Error al eliminar la imagene de la base de datos.');
                }
    
                $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageTitle = $request->file('image')->getClientOriginalName();
    
                $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
                $imageName = $colection->id.'_'.$imageNameSave.'_'.time().'.'.$extension;
                
                $imagePath = 'img/art_colections/'.$imageName;
                $newImage = [
                    'title' => $imageTitle,
                    'location' => $imagePath
                ];
                
                if(!$colection->image()->create($newImage)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen'];
                    return redirect('art/painting/colections/edit/'.$id)
                        ->withErrors($error)
                        ->withInput();
                }
                if (!is_dir(public_path('/').'img/art_colections/')){
                    mkdir(public_path('/').'img/art_colections/', 0770, true);
                }   
                Image::make($request->file('image'))->save(public_path('/').$imagePath);
                
                if (!file_exists(public_path('/').$imagePath)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen'];
                    return redirect('art/painting/colections/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }

                if(!Storage::delete($location)) {
                    DB::rollBack();
                    $error = ['error' => 'Error al eliminar la imagen'];
                    return redirect('art/painting/colections/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }

                DB::commit();
            } catch(Exception $e) {
                DB::rollBack();
                $error = ['error' => $e->getMessage()];
                return redirect('art/painting/colections/edit'.$id)
                            ->withErrors($error)
                            ->withInput();
            }
        }
        $colection->name = $request->get('name');
        $colection->description = $request->get('description');
        $colection->principal_page = $request->get('principal_page');
        if(!$colection->save())
        {
            $error = ['error' => 'Error al actualizar la ubicacion'];
                return redirect('art/painting/colections/edit'.$id)
                            ->withErrors($error)
                            ->withInput();
        }
        return redirect()->route('paint_colection_show_admin', [$id])->with('success','hola');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        
        try {
            DB::beginTransaction();

            $colection = ArtColection::find($request->get('id'));
            
            $imageLocation = $colection->image->location;
            $imageId = $colection->image->id;

            if(!$colection->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar la coleccion']);
            }

            if(!ModelsImage::destroy($imageId)){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar la imagen de la base de datos']);
            }

            if(!Storage::delete('/'.$imageLocation)) {
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
