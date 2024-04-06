<?php

namespace App\Http\Controllers;

use App\Models\ArtColection;
use App\Models\ArtExhibition;
use App\Models\ArtPainting;
use App\Models\HomepageImage;
use App\Models\Image as ModelsImage;
use App\Models\Location;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\DB;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $modelType
     * @param  int  $modelId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($modelType, $modelId)
    {
        return view('Admin/images/images_create', ['modelType' => $modelType, 'modelId' => $modelId]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param string $modelType
     * @param  int  $modelId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $modelType, $modelId)
    {
        $request->validate([
            'images' => 'required|image|max:10240',
            'name' => 'required|string|max:100',
            'hierarchy' => 'required|numeric|min:1|max:10',
            'action' => 'sometimes|string|in:create',
            'description' => 'sometimes|string|max:1000',
        ]);

        if($request->has('action')){
            ModelsImage::setNewModel(true);
            ModelsImage::setIsUpdate(false);
        }

        if($modelType != 'homepage_images'){
            $name = $request->get('name');
            $name = explode('.', $name);
        }else{
            $request->validate(['images' => 'required|image|max:10240']);
        
            $name[1] = pathinfo($request->file('images')->getClientOriginalName(), PATHINFO_EXTENSION);
            $name[0] = $request->file('images')->getClientOriginalName();    
        }

        $imageNameSave = str_replace(' ', '_', $name[0]);
        $imageName = $modelType.'_'.$modelId.'_'.$imageNameSave.'.'.$name[1];

        $model = $this->getModel($modelType, $modelId);

        $imagePath = 'img/'.$modelType.'/'.$imageName;
        $newImage = [
            'title' => $modelType != 'homepage_images' ? $name[0] : $request->get('name'),
            'location' => $imagePath,
            'hierarchy' => $request->get('hierarchy'),
        ];

        if($request->has('description')){
            $newImage['description'] = $request->get('description');
        }

        DB::beginTransaction();
        
        if(!$model->images()->create($newImage)) {
            return response()->json([
                'message' => 'Problemas al guardar la imagen'
            ], 422);
        }

        if (!is_dir(public_path('/').'img/'.$modelType.'/')){
            mkdir(public_path('/').'img/'.$modelType.'/', 0770, true);
        }  
        Image::make($request->file('images'))->save(public_path('/').$imagePath);
        
        if (file_exists(public_path('/').$imagePath)) {
            DB::commit();
        } else {
            DB::rollBack();
            return response()->json([
                'message' => 'Problemas al guardar la imagen'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $modelType
     * @param  int  $modelId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($modelType, $modelId)
    {
        $model = $this->getModel($modelType, $modelId);
        $result = [];
        foreach($model->images as $image) {
            if(file_exists(public_path($image->location))){
                $file['name'] = $image->title; //get the filename in array
                $file['location'] = $image->location;
                $file['extension'] = pathinfo($image->location, PATHINFO_EXTENSION);
                $file['id'] = $image->id;
                $file['hierarchy'] = $image->hierarchy;
                $result[] = $file; // copy it to another array
            }else{
                ModelsImage::destroy($image->id);
            }
        }
        return view('Admin/images/images_edit', ['images' => $result, 'modelType' => $modelType, 'modelId' => $modelId]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $modelType
     * @param  int  $modelId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $modelType, $modelId, $imageId)
    {
        ModelsImage::setIsUpdate(true);
        if($this->store($request, $modelType, $modelId) != null ){
            return false;
        }
        
        if(!$this->destroySingleImage($imageId)) {
            return false;
        }

        return true;
    }

    public function updateImageWithHierarchy(Request $request, $modelType, $modelId){
        $request->validate([
            'images' => 'required|image|max:10240',
            'name' => 'required|string|max:100',
            'hierarchy' => 'required|numeric|min:1|max:10',
            'id' => 'sometimes|numeric|min:1'
        ]);

        ModelsImage::setIsUpdate(true);
        ModelsImage::setNewModel(false);
        if($request->has('id')){
            $image = ModelsImage::find($request->get('id'));
            if($image != null && $image->hierarchy != $request->get('hierarchy')){
                $image->hierarchy = $request->get('hierarchy');
                if(!$image->save()){
                    return response()->json([
                        'message' => 'Problemas al actualizar la imagen'
                    ], 422);
                }
            }
        }else {
            if($this->store($request, $modelType, $modelId) != null ){
                return response()->json([
                    'message' => 'Problemas al guardar la imagen nueva'
                ], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function delete(Request $request)
    {
        $request->validate(['deletedFiles.*' => 'required|numeric']);

        ModelsImage::setIsUpdate(false);
        $locations = ModelsImage::whereIn('id', $request->get('deletedFiles'))->pluck('location')->toArray();

        for ($i=0; $i < count($locations); $i++) { 
            $locations[$i] = '/'.$locations[$i];
        }
        DB::beginTransaction();
        
        if(ModelsImage::destroy($request->get('deletedFiles')) != count($request->get('deletedFiles'))) {
            DB::rollBack();
            return json_encode('Error al eliminar las imagenes de la base de datos.');
        }
        
        if(!Storage::delete($locations)) {
            DB::rollBack();
            return json_encode('Error al eliminar las imagenes');
        }
        DB::commit();
        return json_encode('success');
    }


    public function destroySingleImage($id){
        $image = ModelsImage::find($id);
        $location = $image->location;
        if(ModelsImage::destroy($image->id) != 1) {
            return false;
        }
        
        if(!Storage::delete('/'.$location)) {
            if (file_exists(public_path('/').$location)) {
                return false;
            }
        }
        return true;
    }

    private function getModel($modelType, $modelId){
        $model = false;
        switch($modelType) {
            case "services": 
                $model = Service::find($modelId);
                break;
            case "projects":
                $model = Project::find($modelId);
                break;
            case "exhibitions":
                $model = ArtExhibition::find($modelId);
                break;
            case "paint": 
                $model = ArtPainting::find($modelId);
                break;
            case "team":
                $model = User::find($modelId);
                break;
            case "posts":
                $model = Post::find($modelId);
                break;
            case "locations":
                $model = Location::find($modelId);
                break;
            case "art_colections":
                $model = ArtColection::find($modelId);
                break;
            case "homepage_images":
                $model = HomepageImage::find($modelId);
                break;
        }
        return $model;
    }
}
