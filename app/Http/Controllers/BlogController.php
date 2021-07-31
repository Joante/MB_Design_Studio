<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Image as ModelsImage;
use App\Models\Post;
use App\Rules\PrincipalPage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(8);

        foreach ($posts as $post) {
            $post['created'] = '10/02/2020';//$post->created_at->format('d/m/Y');
        }

        return view('Web/Blog/blog_index', ['posts' => $posts]);
    }

    /**
     * Display a listing of the resource for admin use.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_admin()
    {
        $posts = Post::paginate();

        return view('Admin/blog/blog_index_admin', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('Admin/blog/blog_create', ['categories' => $categories]);
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
            'title' => 'required|string|max:100',
            'category_id' => 'required|numeric',
            'text' => 'required',
            'principal_page' => ['sometimes',new PrincipalPage('blog', 4)],
            'image' => 'required|image|max:5042'
        ]);
        if ($validator->fails()) {
            return redirect('blog/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            DB::beginTransaction();

            $newPost = [
                'title' => $request->get('title'),
                'category_id' => $request->get('category_id'),
                'text' => $request->get('text'),
                'principal_page' => $request->get('principal_page')
            ];
            $post = Post::create($newPost);
            if(!$post) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar el post'];
                return redirect('blog/create')
                    ->withErrors($error)
                    ->withInput();
            }

            $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageTitle = $request->file('image')->getClientOriginalName();

            $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
            $imageName = $post->id.'_'.$imageNameSave.'_'.time().'.'.$extension;
            
            $imagePath = 'img/posts/'.$imageName;
            $newImage = [
                'title' => $imageTitle,
                'location' => $imagePath
            ];
            
            if(!$post->images()->create($newImage)) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen'];
                return redirect('blog/create')
                    ->withErrors($error)
                    ->withInput();
            }
            Image::make($request->file('image'))->save(public_path('/').$imagePath);
            
            if (!file_exists(public_path('/').$imagePath)) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen'];
                return redirect('blog/create')
                        ->withErrors($error)
                        ->withInput();
            }

            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            $error = ['error' => $e->getMessage()];
            return redirect('blog/create')
                        ->withErrors($error)
                        ->withInput();
        }
        
        
        return redirect()->route('blog_index_admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if(!$post) {
            abort('404');
        }
        $post['created'] = $post->created_at->format('d/m/Y');
        return view('Web/Blog/blog_view', ['post' => $post]);
    }

    /**
     * Display the specified resource for admin use.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_admin($id, $message = null)
    {
        $post = Post::find($id);
        if(!$post) {
            return view('errors/model_not_found', ['modelName' => 'post']);
        }

        return view('Admin/blog/blog_show_admin', ['post' => $post, 'message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(!$post) {
            return view('errors/model_not_found', ['modelName' => 'post']);
        }
        $categories = BlogCategory::all();

        return view('Admin/blog/blog_edit', ['post' => $post, 'categories' => $categories]);
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
        $post = Post::find($id);
        if(!$post) {
            return view('errors/model_not_found', ['modelName' => 'post']);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'category_id' => 'required|numeric',
            'text' => 'required',
            'principal_page' => ['sometimes',new PrincipalPage('blog', 4)],
            'image' => 'nullable|image|max:5042'
        ]);
        if ($validator->fails()) {
            return redirect('blog/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        if($request->has('image'))
        {
            try {
                DB::beginTransaction();

                $location = $post->images[0]->location;
                
                if(!ModelsImage::destroy($post->images[0]->id)) {
                    DB::rollBack();
                    return json_encode('Error al eliminar las imagenes de la base de datos.');
                }
                
                $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageTitle = $request->file('image')->getClientOriginalName();
    
                $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
                $imageName = $request->get('title').'_'.$imageNameSave.'_'.time().'.'.$extension;
                
                $imagePath = 'img/posts/'.$imageName;
                $newImage = [
                    'title' => $imageTitle,
                    'location' => $imagePath
                ];

                $post->title = $request->get('title');
                $post->category_id = $request->get('category_id');
                $post->text = $request->get('text');
                $post->principal_page = $request->get('principal_page');
                
                if(!$post->save()) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al actualizar el post'];
                    return redirect('blog/edit/'.$id)
                        ->withErrors($error)
                        ->withInput();
                }
                
                if(!$post->images()->create($newImage)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen nueva'];
                    return redirect('blog/edit/'.$id)
                        ->withErrors($error)
                        ->withInput();
                }
                Image::make($request->file('image'))->save(public_path('/').$imagePath);
                
                if (!file_exists(public_path('/').$imagePath)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen'];
                    return redirect('blog/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }

                if(!Storage::delete($location)) {
                    DB::rollBack();
                    $error = ['error' => 'Error al eliminar la imagen'];
                    return redirect('blog/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
                }
                DB::commit();
            } catch(Exception $e) {
                DB::rollBack();
                $error = ['error' => $e->getMessage()];
                return redirect('blog/edit/'.$id)
                            ->withErrors($error)
                            ->withInput();
            }    
        }else {
            $post->title = $request->get('title');
            $post->category_id = $request->get('category_id');
            $post->text = $request->get('text');
            $post->principal_page = $request->get('principal_page');
            
            if(!$post->save()) {
                $error = ['error' => 'Problemas al actualizar el post'];
                return redirect('blog/edit/'.$id)
                    ->withErrors($error)
                    ->withInput();
            }
        }
        
        return redirect()->route('blog_show_admin', ['id' => $id, 'message' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        
        try {
            DB::beginTransaction();

            $post = Post::find($request->get('id'));
            
            if(!$post->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar el servicio']);
            }
            
            $locations = ['/'.$post->image->location];
            $eliminada = $post->image->delete();
            foreach ($post->images as $image) {
                $locations[] = '/'.$image->location;
                if(!$image->delete() || !$eliminada){
                    DB::rollBack();
                    return json_encode(['message' => 'Error al eliminar las imagenes']);
                }
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
     * Show a list of a determinate Blog Category
     * 
     * @param int $blog_category_id
     * @return \Illuminate\Http\Response
     */
    public function show_category($blog_category_id) {
        $posts = Post::where('category_id', '=', $blog_category_id)->paginate(8);

        foreach ($posts as $post) {
            $post['created'] = $post->created_at->format('d/m/Y');
        }

        $blog_category_title = BlogCategory::find($blog_category_id)->title;

        return view('Web/Blog/blog_category', ['posts' => $posts, 'category_title' => $blog_category_title]);
    }
}
