<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use App\Models\Image as ModelsImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::sortable()->paginate(15);

        return view('Admin/art/exhibitions/locations/location_index', ['locations' => $locations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/art/exhibitions/locations/location_create');
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
            'url' => 'required|url',
            'phone' => 'nullable|numeric',
            'adress' => 'required|string|max:255',
            'image' => 'nullable|image|max:5042'
        ]);
        
        try{
            DB::beginTransaction();

            $newLocation = [
                'name' => $request->get('name'),
                'url' => $request->get('url'),
                'phone' => $request->get('phone'),
                'adress' => $request->get('adress')
            ];
            $location = Location::create($newLocation);
            if(!$location) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la ubicacion'];
                return redirect('art/exhibition/locations/create')
                    ->withErrors($error)
                    ->withInput();
            }
            if($request->has('image'))
            {
                $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageTitle = $request->file('image')->getClientOriginalName();

                $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
                $imageName = $location->id.'_'.$imageNameSave.'_'.time().'.'.$extension;
                
                $imagePath = 'img/locations/'.$imageName;
                $newImage = [
                    'title' => $imageTitle,
                    'location' => $imagePath
                ];
                
                if(!$location->image()->create($newImage)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen'];
                    return redirect('art/exhibition/locations/create')
                        ->withErrors($error)
                        ->withInput();
                }
                Image::make($request->file('image'))->save(public_path('/').$imagePath);
                
                if (!file_exists(public_path('/').$imagePath)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen'];
                    return redirect('art/exhibition/locations/create')
                            ->withErrors($error)
                            ->withInput();
                }
            }
            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            $error = ['error' => $e->getMessage()];
            return redirect('art/exhibition/locations/create')
                        ->withErrors($error)
                        ->withInput();
        }
        
        
        return redirect()->route('location_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::find($id);

        if(!$location) {
            return view('errors/model_not_found', ['modelName' => 'ubicacion']);
        }

        return view('Admin/art/exhibitions/locations/location_show', ['location' => $location]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::find($id);

        if(!$location) {
            return view('errors/model_not_found', ['modelName' => 'ubicacion']);
        }
        return view('Admin/art/exhibitions/locations/location_edit', ['location' => $location]);
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
        $location = Location::find($id);

        if(!$location) {
            return view('errors/model_not_found', ['modelName' => 'ubicacion']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'phone' => 'nullable|numeric',
            'adress' => 'required|string|max:255',
            'image' => 'nullable|image|max:5042'
        ]);

        if($request->has('image'))
        {
            try{
                DB::beginTransaction();

                $location = $location->image->location;
                
                if(!ModelsImage::destroy($location->image->id)) {
                    DB::rollBack();
                    return json_encode('Error al eliminar la imagene de la base de datos.');
                }

                $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageTitle = $request->file('image')->getClientOriginalName();
    
                $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
                $imageName = $location->id.'_'.$imageNameSave.'_'.time().'.'.$extension;
                
                $imagePath = 'img/locations/'.$imageName;
                $newImage = [
                    'title' => $imageTitle,
                    'location' => $imagePath
                ];
                
                if(!$location->image()->create($newImage)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen en la base de datos'];
                    return redirect('art/exhibition/locations/edit/'.$id)
                        ->withErrors($error)
                        ->withInput();
                }
                Image::make($request->file('image'))->save(public_path('/').$imagePath);
                
                if (!file_exists(public_path('/').$imagePath)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen'];
                    return redirect('art/exhibition/locations/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }

                if(!Storage::delete($location)) {
                    DB::rollBack();
                    $error = ['error' => 'Error al eliminar la imagen'];
                    return redirect('art/exhibition/locations/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }

                DB::commit();
            } catch(Exception $e) {
                DB::rollBack();
                $error = ['error' => $e->getMessage()];
                return redirect('art/exhibition/locations/edit'.$id)
                            ->withErrors($error)
                            ->withInput();
            }
        }
        $location->name = $request->get('name');
        $location->url = $request->get('url');
        $location->phone = $request->get('phone');
        $location->adress = $request->get('adress');
        if(!$location->save())
        {
            $error = ['error' => 'Error al actualizar la ubicacion'];
                return redirect('art/exhibition/locations/edit'.$id)
                            ->withErrors($error)
                            ->withInput();
        }
        return redirect()->route('location_show', [$id])->with('success','hola');
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

            $location = Location::find($request->get('id'));
            
            $imageLocation = $location->image->location;
            $imageId = $location->image->id;

            if(!$location->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar la ubicacion']);
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
