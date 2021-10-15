<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = BlogCategory::sortable()->paginate(15);

        return view('Admin/blog_categories/blog_categories_index_admin', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/blog_categories/blog_categories_create');
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
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:255'
        ]);

        BlogCategory::create($request->all());

        return redirect()->route('blog_categories_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = BlogCategory::find($id);
        if(!$category){
            return view('errors/model_not_found', ['modelName' => 'categoria']);
        }
        
        return view('Admin/blog_categories/blog_categories_show_admin', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = BlogCategory::find($id);
        if(!$category){
            return view('errors/model_not_found', ['modelName' => 'categoria']);
        }
        return view('Admin/blog_categories/blog_categories_edit', ['category' => $category]);
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
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:255'
        ]);

        $category = BlogCategory::find($id);

        $category->title = $request->get('title');
        $category->description = $request->get('description');
        if(!$category->save()) {
            $error = ['error' => 'Problemas al actualizar la categoria'];
            return redirect('blog/category/edit/'.$id)
                ->withErrors($error)
                ->withInput();
        }

        return redirect()->route('blog_category_show', [$id])->with('success','hola');
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
        $count = DB::table('posts')->where('category_id', '=', $request->get('id'))->count();
        if($count > 0)
        {
            return json_encode(['message' => 'No se puede eliminar la categoria por que tiene posts asociados.']);
        }
        
        $category = BlogCategory::find($request->get('id'));

        if(!$category->delete()) {
            $message = ['message' => 'No se pudo eliminar la categoria de la base de datos.']; 
        } else {
            $message = ['message' => 'success'];
        }

        return json_encode($message);
    }
}
