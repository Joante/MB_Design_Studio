<?php

namespace App\Http\Controllers;

use App\Events\HierarchyChange;
use App\Models\HomepageImage;
use App\Models\Image as ModelsImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class HomepageImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $homepageImages = HomepageImage::orderBy('hierarchy')->paginate(15);
        return view('Admin.homepage_images.homepage_images_index', ['homepageImages' => $homepageImages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $hierarchy = HomepageImage::count();
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
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'image' => 'required|image|max:10240',
            'hierarchy' => 'nullable|numeric|min:1'
        ]);

        try{
            DB::beginTransaction();

            $hierarchy = $request->get('hierarchy');
            if($hierarchy == null){
                $hierarchy = HomepageImage::count();
                if($hierarchy == 0){
                    $hierarchy = 1;
                }
            }else {
                event(new HierarchyChange($hierarchy, 'homepage_images'));
            }

            $newHomepageImage = [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'hierarchy' => $hierarchy,
            ];

            $homepageImage = HomepageImage::create($newHomepageImage);
            if(!$homepageImage) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen de la homepage'];
                return redirect('homepage_images/create')
                    ->withErrors($error)
                    ->withInput();
            }
            
            $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageTitle = $request->file('image')->getClientOriginalName();

            $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
            $imageName = $homepageImage->id.'_'.$imageNameSave.'_'.time().'.'.$extension;
            
            $imagePath = 'img/locations/'.$imageName;
            $newImage = [
                'title' => $imageTitle,
                'location' => $imagePath
            ];
            
            if(!$homepageImage->image()->create($newImage)) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen'];
                return redirect('homepage_images/create')
                    ->withErrors($error)
                    ->withInput();
            }
            if (!is_dir(public_path('/').'img/locations/')){
                mkdir(public_path('/').'img/locations/', 0770, true);
            } 
            Image::make($request->file('image'))->save(public_path('/').$imagePath);
            
            if (!file_exists(public_path('/').$imagePath)) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen'];
                return redirect('homepage_images/create')
                        ->withErrors($error)
                        ->withInput();
            }
            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            $error = ['error' => $e->getMessage()];
            return redirect('homepage_images/create')
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
        $homepageImage = HomepageImage::find($id);
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
        $homepageImage = HomepageImage::find($id);
        if(!$homepageImage) {
            abort('404');
        }
        $hierarchy = HomepageImage::count();
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
        $homepageImage = HomepageImage::find($id);

        if(!$homepageImage) {
            return view('errors/model_not_found', ['modelName' => 'ubicacion']);
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|max:10240',
            'hierarchy' => 'required|numeric|min:1'
        ]);

        if($request->has('image'))
        {
            try{
                DB::beginTransaction();

                $homepageImage = $homepageImage->image->location;
                
                if(!ModelsImage::destroy($homepageImage->image->id)) {
                    DB::rollBack();
                    return json_encode('Error al eliminar la imagen de la base de datos.');
                }

                $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageTitle = $request->file('image')->getClientOriginalName();
    
                $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
                $imageName = $homepageImage->id.'_'.$imageNameSave.'_'.time().'.'.$extension;
                
                $imagePath = 'img/locations/'.$imageName;
                $newImage = [
                    'title' => $imageTitle,
                    'location' => $imagePath
                ];
                
                if(!$homepageImage->image()->create($newImage)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen en la base de datos'];
                    return redirect('homepage_images/edit/'.$id)
                        ->withErrors($error)
                        ->withInput();
                }
                if (!is_dir(public_path('/').'img/locations/')){
                    mkdir(public_path('/').'img/locations/', 0770, true);
                } 
                Image::make($request->file('image'))->save(public_path('/').$imagePath);
                
                if (!file_exists(public_path('/').$imagePath)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen'];
                    return redirect('homepage_images/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }

                if(!Storage::delete($homepageImage)) {
                    DB::rollBack();
                    $error = ['error' => 'Error al eliminar la imagen'];
                    return redirect('homepage_images/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }

                DB::commit();
            } catch(Exception $e) {
                DB::rollBack();
                $error = ['error' => $e->getMessage()];
                return redirect('homepage_images/edit'.$id)
                            ->withErrors($error)
                            ->withInput();
            }
        }

        if($request->get('hierarchy') != $homepageImage->hierarchy){
            $homepageImage->hierarchy = -1;
            if(!$homepageImage->save())
            {
                $error = ['error' => 'Error al actualizar la imagen de la homepage'];
                    return redirect('homepage_images/edit'.$id)
                                ->withErrors($error)
                                ->withInput();
            }
            event(new HierarchyChange($request->get('hierarchy'), 'homepage_images'));
        }
        $homepageImage->title = $request->get('title');
        $homepageImage->description = $request->get('description');
        $homepageImage->hierarchy = $request->get('hierarchy');
        if(!$homepageImage->save())
        {
            $error = ['error' => 'Error al actualizar la imagen de la homepage'];
                return redirect('homepage_images/edit'.$id)
                            ->withErrors($error)
                            ->withInput();
        }
        return redirect()->route('homepage_images_show', [$id])->with('success','hola');
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
        
        try {
            DB::beginTransaction();

            $homepageImage = HomepageImage::find($request->get('id'));
            $location = $homepageImage->image->location;
            if(!$homepageImage->image->delete()){
                    DB::rollBack();
                    return json_encode(['message' => 'Error al eliminar la imagen']);
            }

            if(!$homepageImage->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar la imagen de la homepage']);
            }
            
            if(!Storage::delete($location)) {
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
