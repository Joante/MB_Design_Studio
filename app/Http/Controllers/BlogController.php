<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Image as ModelsImage;
use App\Models\Post;
use App\Models\User;
use App\Rules\PrincipalPage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use App\Http\Controllers\ImagesController;

class BlogController extends Controller
{
    private $modelType = 'posts';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(8);

        foreach ($posts as $post) {
            $post['created'] = $post->created_at->format('d/m/Y');
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
        $posts = Post::sortable()->paginate(15);

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
            'images' => 'required|image|max:10240'
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

            $imageController = new ImagesController();

            $request->except(['title', 'category_id','text', 'principal_page']);
            $response = $imageController->store($request, $this->modelType, $post->id);
           
            if($response != null) {
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

        $location = ModelsImage::where('model_type', '=', 'App\Models\User')->where('model_id', '=', 1)->value('location');

        if(!$location) {
            $location = 'img/600x600.jpg';
        }
        
        $description = User::where('id', '=', 1)->value('description');
        return view('Web/Blog/blog_view', ['post' => $post, 'location' => $location, 'description' => $description]);
    }

    /**
     * Display the specified resource for admin use.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_admin($id)
    {
        $post = Post::find($id);
        if(!$post) {
            return view('errors/model_not_found', ['modelName' => 'post']);
        }

        return view('Admin/blog/blog_show_admin', ['post' => $post]);
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
            'principal_page' => ['sometimes',new PrincipalPage('blog', 4, $id)],
            'images' => ['sometimes','image', 'max:10240']
        ]);
        if ($validator->fails()) {
            return redirect('blog/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        if($request->has('images'))
        {
            try {
                DB::beginTransaction();

                $imagesController = new ImagesController();

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
                
                $request->except(['title', 'category_id','text', 'principal_page']);
                if(!$imagesController->update($request, $this->modelType, $post->id, $post->images->id)) {
                    DB::rollBack();
                    $error = ['error' => 'Problemas al guardar la imagen nueva'];
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
        
        return redirect()->route('blog_show_admin', [$id])->with('success','hola');
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

            $post = Post::find($request->get('id'));
            $imageId = $post->images->id;
            $imagesController = new ImagesController();
            
            if(!$post->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar el post']);
            }

            if(!$imagesController->destroySingleImage($imageId)) {
                DB::rollBack();
                return json_encode('Error al eliminar las imagenes de la base de datos.');
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
