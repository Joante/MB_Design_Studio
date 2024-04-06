<?php

namespace App\Http\Controllers;

use App\Models\Image as ModelsImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageImagesController extends Controller
{
    private $model_type = 'homepage_images';
    private $model_type_db = 'App\\Models\\HomepageImage';
    private $model_id = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $homepageImages = ModelsImage::where('model_type', $this->model_type_db)->orderBy('hierarchy')->paginate(15);
        return view('Admin.homepage_images.homepage_images_index', ['homepageImages' => $homepageImages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $hierarchy = ModelsImage::where('model_type', $this->model_type_db)->count();
        return view('Admin.homepage_images.homepage_images_create', ['hierarchy' => $hierarchy]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'images' => 'required|image|max:10240',
            'hierarchy' => 'nullable|numeric|min:1'
        ]);
        $image = new ImagesController();
        
        if($request->get('hierarchy') == null){
            $request->merge(['hierarchy' => ModelsImage::where('model_type', $this->model_type_db)->count()+1]);
        }

        if($image->store($request, $this->model_type, $this->model_id) != null ){
            $error = ['error' => 'Error al crear la imagen de la homepage'];
            return redirect('homepage_images/create/')
                    ->withErrors($error)
                    ->withInput();
        }
        
        
        return redirect()->route('homepage_images_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $homepageImage = ModelsImage::where('model_type', $this->model_type_db)->find($id);
        if(!$homepageImage) {
            abort('404');
        }
        return view('Admin.homepage_images.homepage_images_show', ['homepageImage' => $homepageImage]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $homepageImage = ModelsImage::where('model_type', $this->model_type_db)->find($id);
        if(!$homepageImage) {
            abort('404');
        }
        $hierarchy = ModelsImage::where('model_type', $this->model_type_db)->count();
        return view('Admin.homepage_images.homepage_images_edit', ['homepageImage' => $homepageImage, 'hierarchy' => $hierarchy]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|bool|string
     */
    public function update(Request $request, $id)
    {
        $homepageImage = ModelsImage::where('model_type', $this->model_type_db)->find($id);

        if(!$homepageImage) {
            return view('errors/model_not_found', ['modelName' => 'ubicacion']);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'images' => 'nullable|image|max:10240',
            'hierarchy' => 'required|numeric|min:1'
        ]);

        try{
            DB::beginTransaction();
            ModelsImage::setIsUpdate(true);
            ModelsImage::setNewModel(false);
            $homepageImage->title = $request->get('name');
            $homepageImage->description = $request->get('description');
            $homepageImage->hierarchy = $request->get('hierarchy');
            if(!$homepageImage->save())
            {
                $error = ['error' => 'Error al actualizar la imagen de la homepage'];
                    return redirect('homepage_images/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
            }

            if($request->has('images'))
            {
                $imagesController = new ImagesController();
                if (!$imagesController->update($request, $this->model_type, $this->model_id, $homepageImage->id)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al actualizar la imagen'];
                    return redirect('homepage_images/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }
            } 
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            $error = ['error' => $e->getMessage()];
            return redirect('homepage_images/edit/'.$id)
                        ->withErrors($error)
                        ->withInput();
        }

        return redirect()->route('homepage_images_index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        $idArray = ['deletedFiles' => [$request->get('id')]];
        $request->except(['id']);
        $request->merge($idArray);
        $imagesController = new ImagesController();

        $response = $imagesController->delete($request);

        return json_encode(['message' => json_decode($response)]);
    }
}
