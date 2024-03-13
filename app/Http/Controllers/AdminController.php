<?php

namespace App\Http\Controllers;

use App\Models\Acounts;
use App\Models\Degrees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use App\Models\Image as ModelsImage;
use App\Models\Information;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    
    public function index() {
        return view('Admin/index_admin');
    }

    public function edit() {
        $perAcounts = Acounts::where('type', '=', 'personal')->first();
        $mbAcounts = Acounts::where('type', '=', 'mb')->first();
        $about = Information::first();;
        $degrees = Degrees::all();
        return view('Admin/account/settings', ['perAcounts' => $perAcounts, 'mbAcounts' => $mbAcounts, 'about' => $about->about, 'degrees' => $degrees]);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'alpha_dash', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect('admin/settings')
                        ->withErrors($validator)
                        ->withInput();
        }

        Auth::user()->username = $request->get('username');
        Auth::user()->name = $request->get('name');
        Auth::user()->save();

        return redirect()->route('admin_edit');
    }

    public function avatar_update(Request $request) {
        $request->validate(['image' => 'required|image|max:10240']);
    
        if(count(Auth::user()->images) == 0) {
            DB::beginTransaction();
            $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageTitle = $request->file('image')->getClientOriginalName();

            $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
            $imageName = Auth::user()->id.'_'.$imageNameSave.'_'.time().'.'.$extension;
            
            $imagePath = 'img/team/'.$imageName;
            $newImage = [
                'title' => $imageTitle,
                'location' => $imagePath
            ];
            
            if(!Auth::user()->images()->create($newImage)) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen'];
                return redirect('admin/settings')
                    ->withErrors($error)
                    ->withInput();
            }
            if (!is_dir(public_path('/').'img/team/')){
                mkdir(public_path('/').'img/team/', 0770, true);
            }   
            Image::make($request->file('image'))->save(public_path('/').$imagePath);
            
            if (!file_exists(public_path('/').$imagePath)) {
                DB::rollBack();
                $error = ['error' => 'Problemas al guardar la imagen'];
                return redirect('admin/settings')
                        ->withErrors($error)
                        ->withInput();
            }
            DB::commit();
        } else {
            try {
                DB::beginTransaction();

                $location = Auth::user()->images[0]->location;
                
                if(!ModelsImage::destroy(Auth::user()->images[0]->id)) {
                    DB::rollBack();
                    return json_encode('Error al eliminar las imagenes de la base de datos.');
                }
                
                $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageTitle = $request->file('image')->getClientOriginalName();
    
                $imageNameSave = str_replace(' ', '_', pathinfo($request->file('image')->getClientOriginalName(),PATHINFO_FILENAME));
                $imageName = $request->get('title').'_'.$imageNameSave.'_'.time().'.'.$extension;
                
                $imagePath = 'img/team/'.$imageName;
                $newImage = [
                    'title' => $imageTitle,
                    'location' => $imagePath
                ];
                             
                if(!Auth::user()->images()->create($newImage)) {
                    DB::rollBack();
                    $error = ['image' => 'Problemas al guardar la imagen nueva'];
                    return redirect('admin/settings')
                        ->withErrors($error)
                        ->withInput();
                }
                if (!is_dir(public_path('/').'img/team/')){
                    mkdir(public_path('/').'img/team/', 0770, true);
                }   
                Image::make($request->file('image'))->save(public_path('/').$imagePath);
                
                if (!file_exists(public_path('/').$imagePath)) {
                    DB::rollBack();
                    $error = ['image' => 'Problemas al guardar la imagen'];
                    return redirect('admin/settings')
                            ->withErrors($error)
                            ->withInput();
                }

                if(!Storage::delete($location)) {
                    DB::rollBack();
                    $error = ['image' => 'Error al eliminar la imagen'];
                    return redirect('admin/settings')
                            ->withErrors($error)
                            ->withInput();
                }
                DB::commit();
            } catch(Exception $e) {
                DB::rollBack();
                $error = ['image' => $e->getMessage()];
                return redirect('admin/settings')
                            ->withErrors($error)
                            ->withInput();
            }    
        }

        return redirect()->route('admin_edit');
    }

    public function change_password(Request $request) {
        $request->validate([
            'actual_password' => 'required|string|min:8|current_password:web',
            'password' => 'required|string|min:8|confirmed'
        ]);

        Auth::user()->password = Hash::make($request->get('password'));

        Auth::user()->save();

        return redirect()->route('admin_edit'); 
    }

    public function update_socials(Request $request) {
        $request->validate([
            'mb_email' => 'nullable|email',
            'mb_twitter' => 'nullable|string',
            'mb_facebook' => 'nullable|string',
            'mb_linkedin' => 'nullable|string',
            'mb_instagram' => 'nullable|string',
            'mb_pinterest' => 'nullable|string',
            'mb_phone' => 'nullable|numeric',
            'personal_email' => 'nullable|email',
            'personal_twitter' => 'nullable|string',
            'personal_facebook' => 'nullable|string',
            'personal_linkedin' => 'nullable|string',
            'personal_instagram' => 'nullable|string',
            'personal_pinterest' => 'nullable|string',
            'personal_phone' => 'nullable|numeric',
        ]);

        $perAcounts = Acounts::where('type', '=', 'personal')->first();
        $mbAcounts = Acounts::where('type', '=', 'mb')->first();

        $perAcounts->email = $request->get('personal_email');
        $perAcounts->twitter = $request->get('personal_twitter');
        $perAcounts->facebook = $request->get('personal_facebook');
        $perAcounts->linkedin = $request->get('personal_linkedin');
        $perAcounts->pinterest = $request->get('personal_pinterest');
        $perAcounts->whats_app = $request->get('personal_phone');

        $mbAcounts->email = $request->get('mb_email');
        $mbAcounts->twitter = $request->get('mb_twitter');
        $mbAcounts->facebook = $request->get('mb_facebook');
        $mbAcounts->linkedin = $request->get('mb_linkedin');
        $mbAcounts->pinterest = $request->get('mb_pinterest');
        $mbAcounts->whats_app = $request->get('mb_phone');

        if(!$perAcounts->save()) {
            $error = ['personal' => $perAcounts];
            return redirect('admin/settings')
                        ->withErrors($error)
                        ->withInput();
        }
        if(!$mbAcounts->save()) {
            $error = ['mb' => $perAcounts];
            return redirect('admin/settings')
                        ->withErrors($error)
                        ->withInput();
        }
        return redirect()->route('admin_edit'); 
    }

    public function store_degree(Request $request){
        $validator = Validator::make($request->all(), [
            'description' => ['string', 'required', 'max:255'],
            'type' => ['required', 'string', Rule::in(['course', 'bachelor'])],
        ]);

        if ($validator->fails()) {
            return redirect('admin/settings')
                        ->withErrors($validator)
                        ->withInput();
        }

        if(!Degrees::create($request->all())){
            $error = ['error' => 'Problemas al crear el titulo'];
                    return redirect('admin/settings')
                        ->withErrors($error)
                        ->withInput();
        }

        return redirect()->route('admin_edit'); 
    }
    public function update_degree(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'description' => ['string', 'required', 'max:255'],
            'type' => ['required', 'string', Rule::in(['course', 'bachelor'])],
        ]);

        if ($validator->fails()) {
            return redirect('admin/settings')
                        ->withErrors($validator)
                        ->withInput();
        }

        $degree = Degrees::find($id);

        if(!$degree) {
            return view('errors/model_not_found', ['modelName' => 'degree']);
        }

        $degree->description = $request->get('description');
        $degree->type = $request->get('type');

        if(!$degree->save()){
            $error = ['error' => 'Problemas al actualizar el titulo'];
                    return redirect('admin/settings')
                        ->withErrors($error)
                        ->withInput();
        }

        return redirect()->route('admin_edit'); 
    }

    public function destroy_degree(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        
        try {
            $degree = Degrees::find($request->get('id'));

            if(!$degree->delete()){
                DB::rollBack();
                return json_encode(['message' => 'Error al eliminar el titulo']);
            }
        } catch(Exception $e){
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