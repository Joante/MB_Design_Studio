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
     * @param string $modelType
     * @param  int  $modelId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $modelType, $modelId)
    {
        $request->validate(['images' => 'required|image|max:10240']);
        
        $extension = pathinfo($request->file('images')->getClientOriginalName(), PATHINFO_EXTENSION);
        $imageTitle = $request->file('images')->getClientOriginalName();

        $imageNameSave = str_replace(' ', '_', pathinfo($request->file('images')->getClientOriginalName(),PATHINFO_FILENAME));
        $imageName = $modelType.'_'.$modelId.'_'.$imageNameSave.'.'.$extension;
        
        $model = $this->getModel($modelType, $modelId);

        $imagePath = 'img/'.$modelType.'/'.$imageName;
        $newImage = [
            'title' => $imageTitle,
            'location' => $imagePath
        ];
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
                $file['size'] = filesize($image->location); //get the flesize in array
                $file['location'] = $image->location;
                $file['extension'] = pathinfo($image->title, PATHINFO_EXTENSION);
                $file['id'] = $image->id;
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
        if($this->store($request, $modelType, $modelId) != null ){
            return false;
        }
        
        if(!$this->destroySingleImage($imageId)) {
            return false;
        }

        return true;
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
            return false;
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
