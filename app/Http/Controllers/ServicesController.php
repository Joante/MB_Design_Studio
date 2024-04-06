<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use App\Models\Project;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Rules\PrincipalPage;
use Illuminate\Support\Facades\Validator;
use Image;

class ServicesController extends Controller
{
    /**
     * Devuelve la página para mostrar los servicios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Web/Services/services_index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_admin()
    {
        $services = Service::sortable()->paginate(15);

        return view('Admin/services/services_index_admin', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $icons = Icon::all();
        return view('Admin/services/services_create', ['icons' => $icons]);
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
            'description' => 'required|string|max:500',
            'text' => 'required',
            'icon' => 'required_unless:newIcon,on|numeric',
            'iconFile' => 'required_if:newIcon,on|image|max:2048',
            'principal_page' => ['sometimes',new PrincipalPage('services', 4)]
        ]);
        if ($validator->fails()) {
            return redirect('services/create')
                        ->withErrors($validator)
                        ->withInput();
        }        
        
        $newService = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'text' => $request->get('text'),
            'principal_page' => $request->get('principal_page')
        ];
        if($request->has('newIcon'))
        {
            $iconName = time().'.'.$request->file('iconFile')->extension();
            $newIcon = [
                'title' => 'icon_new',
                'location' => $iconName
            ];
            $icon = Icon::create($newIcon);
            Image::make($request->file('iconFile'))->resize(200, 140)->save(public_path('/img/icons/').$iconName);
            $newService['icon_id'] = $icon->id;
        }else {
            $newService['icon_id'] = $request->get('icon');
        }
        $service = Service::create($newService);
        return redirect()->route('images_create_model', ['modelType' => 'services', 'modelId' => $service->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);
        if(!$service){
            abort(404);
        }

        $projects = Project::limit(5)->get();
        return view('Web/Services/services_view', ['service' => $service, 'projects' => $projects]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_admin($id)
    {
        $service = Service::find($id);
        if(!$service){
            return view('errors/model_not_found', ['modelName' => 'servicio']);
        }
        
        return view('Admin/services/services_show_admin', ['service' => $service]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::find($id);
        if(!$service){
            return view('errors/model_not_found', ['modelName' => 'servicio']);
        }

        $icons = Icon::all();
        return view('Admin/services/services_edit', ['service' => $service, 'icons' => $icons]);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'text' => 'required',
            'icon' => 'required_unless:newIcon,on|numeric',
            'iconFile' => 'required_if:newIcon,on|image|max:2048',
            'principal_page' => ['sometimes',new PrincipalPage('services', 4, $id)]
        ]);
        if ($validator->fails()) {
            return redirect('/services/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }    

        $service = Service::find($id);
        if(!$service){
            return view('errors/model_not_found', ['modelName' => 'servicio']);
        }
        
        $service->title = $request->get('title');
        $service->description = $request->get('description');
        $service->text = $request->get('text');
        $service->principal_page = $request->has('principal_page') ? true : false;

        if($request->has('newIcon'))
        {
            $iconName = time().'.'.$request->file('iconFile')->extension();
            $newIcon = [
                'title' => 'icon_new',
                'location' => $iconName
            ];
            $icon = Icon::create($newIcon);
            Image::make($request->file('iconFile'))->resize(200, 140)->save(public_path('/img/icons/').$iconName);
            $service->icon_id = $icon->id;
        }else {
            $service->icon_id = $request->get('icon');
        }
        $service->save();
        return redirect()->route('services_show_admin', [$id])->with('success','hola');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);

        try {
            DB::beginTransaction();

            $service = Service::find($request->get('id'));
            $locations = [];
            foreach ($service->images as $image) {
                $locations[] = '/'.$image->location;
                if(!$image->delete()){
                    DB::rollBack();
                    return json_encode(['message' => 'Error al eliminar las imagenes']);
                }
            }

            if(!$service->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar el servicio']);
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
