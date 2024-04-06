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
            'images' => 'nullable|image|max:10240'
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
            if($request->has('images'))
            {
                $imageTitle = $request->file('images')->getClientOriginalName();
                $request->except(['name', 'url', 'phone', 'adress']);
                $request->merge(['hierarchy' => 2, 'name' => $imageTitle]);
                $imagesController = new ImagesController();

                $response = $imagesController->store($request, 'locations', $location->id);
                
                if ($response != null) {
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
            'images' => 'nullable|image|max:10240'
        ]);

        try{
            DB::beginTransaction();

            $location->name = $request->get('name');
            $location->url = $request->get('url');
            $location->phone = $request->get('phone');
            $location->adress = $request->get('adress');
            if(!$location->save())
            {
                $error = ['error' => 'Error al actualizar la ubicacion'];
                    return redirect('art/exhibition/locations/edit/'.$id)
                                ->withErrors($error)
                                ->withInput();
            }

            if($request->has('images'))
            {
                $imageTitle = $request->file('images')->getClientOriginalName();
                $request->except(['name', 'url', 'phone', 'adress']);
                $request->merge(['hierarchy' => 2, 'name' => $imageTitle]);
                $imagesController = new ImagesController();

                if($imagesController->update($request, 'locations', $location->id, $location->images->id) == 'hola') {
                    DB::rollBack();
                    $error = ['error' => 'Error al actualizar la imagen'];
                    return redirect('art/exhibition/locations/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }
            }

            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            $error = ['error' => $e->getMessage()];
            return redirect('art/exhibition/locations/edit/'.$id)
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
            $imagesController = new ImagesController();
            $imageId = $location->images->id;

            if(!$location->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar la ubicacion']);
            }

            if(!$imagesController->destroySingleImage($imageId)){
                DB::rollBack();
                return json_encode(['message'=> 'Error al eliminar la imagen']);
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
