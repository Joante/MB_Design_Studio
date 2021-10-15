<?php

namespace App\Http\Controllers;

use App\Models\Acounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use App\Models\Image as ModelsImage;
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
        return view('Admin/account/settings', ['perAcounts' => $perAcounts, 'mbAcounts' => $mbAcounts]);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'alpha_dash', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return redirect('admin/settings')
                        ->withErrors($validator)
                        ->withInput();
        }

        Auth::user()->username = $request->get('username');
        Auth::user()->name = $request->get('name');
        Auth::user()->description = $request->get('description');
        Auth::user()->save();

        return redirect()->route('admin_edit');
    }

    public function avatar_update(Request $request) {
        $request->validate(['image' => 'required|image|max:5042']);
    
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
                    return rredirect('admin/settings')
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

        dd($request);
    }
}
