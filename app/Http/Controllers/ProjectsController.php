<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Rules\PrincipalPage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory| \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $services_id = Service::pluck('id');
        $categories = Project::groupBy('service_id')->pluck('service_id')->toArray();
        $projects = [];
        foreach($services_id as $id) {
            $results = Project::where('service_id', '=', $id)->limit(2)->latest()->get();
            if(!empty($results->all())) {
                foreach ($results as $result) {
                    $projects[] = $result;
                }
            }
        }
        
        return view('Web/Projects/projects_index', ['projects' => $projects, 'categories' => $categories]);
    }

    /**
     * Display a listing of the resource for admin use.
     *
     * @return \Illuminate\Contracts\View\Factory| \Illuminate\Contracts\View\View
     */
    public function index_admin()
    {
        $projects = Project::sortable()->paginate(15);

        return view('Admin/projects/projects_index_admin', ['projects' => $projects]);
    }

    /**
     * Display a listing of all the entrys for the specific category
     * 
     * @param int $category_id
     * @return \Illuminate\Contracts\View\Factory| \Illuminate\Contracts\View\View
     */
    public function show_category($category_id) {
        $projects = Project::where('service_id', '=', $category_id)->paginate(6);
        $service = Service::find($category_id);
        if(!$service) {
            abort('404');
        }
        $service_title = $service->title;

        return view('Web/Projects/projects_category', ['projects' => $projects, 'service' => $service_title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory| \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('Admin/projects/projects_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response| \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'client' => 'nullable|string|max:100',
            'description' => 'required',
            'location' => 'nullable|string|max:100',
            'service_id' => 'required|numeric',
            'principal_page' => ['sometimes',new PrincipalPage('projects', 6)],
            'area' => 'required|numeric|min:1'
        ]);
        if ($validator->fails()) {
            return redirect('projects/create')
                        ->withErrors($validator)
                        ->withInput();
        }        
        $project = Project::create($request->all());
        return redirect()->route('images_create_model', ['modelType' => 'projects', 'modelId' => $project->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory| \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $project = Project::find($id);
        if(!$project) {
            abort('404');
        }
        $next = Project::where('id', '>', $project->id)->orderBy('id')->first();
        $previous = Project::where('id', '<', $project->id)->orderBy('id','desc')->first();
        return view('Web/Projects/projects_view', ['project' => $project, 'next' => $next, 'previous' => $previous]);
    }

    /**
     * Display the specified resource for admin use.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory| \Illuminate\Contracts\View\View
     */
    public function show_admin($id)
    {
        $project = Project::find($id);
        if(!$project){
            return view('errors/model_not_found', ['modelName' => 'proyecto']);
        }
        
        return view('Admin/projects/projects_show_admin', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory| \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $project = Project::find($id);
        if(!$project){
            return view('errors/model_not_found', ['modelName' => 'proyecto']);
        }
        return view('Admin/projects/projects_edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory| \Illuminate\Contracts\View\View | \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if(!$project){
            return view('errors/model_not_found', ['modelName' => 'proyecto']);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'client' => 'nullable|string|max:100',
            'description' => 'required',
            'location' => 'nullable|string|max:100',
            'service_id' => 'required|numeric',
            'principal_page' => ['sometimes',new PrincipalPage('projects', 6, $id)],
            'area' => 'required|numeric|min:1'
        ]);
        if ($validator->fails()) {
            return redirect('projects/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }        
        $project->title = $request->get('title');
        $project->client = $request->get('client');
        $project->description = $request->get('description');
        $project->location = $request->get('location');
        $project->service_id = $request->get('service_id');
        $project->principal_page = $request->get('principal_page');
        $project->area = $request->get('area');
        $project->save();

        return redirect()->route('projects_show_admin', [$id])->with('success','hola');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return bool|string
     */
    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        
        try {
            DB::beginTransaction();

            $project = Project::find($request->get('id'));
            $locations = [];
            foreach ($project->images as $image) {
                $locations[] = '/'.$image->location;
                if(!$image->delete()){
                    DB::rollBack();
                    return json_encode(['message' => 'Error al eliminar las imagenes']);
                }
            }

            if(!$project->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar el proyecto']);
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
}
