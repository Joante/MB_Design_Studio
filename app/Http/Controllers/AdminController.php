<?php

namespace App\Http\Controllers;

use App\Models\Acounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Information;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    
    public function index() {
        return view('Admin/index_admin');
    }

    public function edit() {
        $perAcounts = Acounts::where('type', '=', 'personal')->first();
        $mbAcounts = Acounts::where('type', '=', 'mb')->first();
        $about = Information::first();
        $aboutText = $about != null ? $about->about : '';
        return view('Admin/account/settings', ['perAcounts' => $perAcounts, 'mbAcounts' => $mbAcounts, 'about' => $aboutText]);
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
        $request->validate(['images' => 'required|image|max:10240']);

        $imagesController = new ImagesController();
        $imageTitle = $request->file('images')->getClientOriginalName();
        if(Auth::user()->images == null) {
            DB::beginTransaction();

            $request->merge(['hierarchy' => 1, 'name' => $imageTitle]);
            $response = $imagesController->store($request, 'team', Auth::user()->id);
            
            if ($response != null) {
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
                $request->merge(['hierarchy' => 2, 'name' => $imageTitle]);

                if(!$imagesController->update($request,'team', Auth::user()->id, Auth::user()->images->id)) {
                    DB::rollBack();
                    $error = ['images' => 'Error al actualizar la imagen'];
                    return redirect('admin/settings')
                            ->withErrors($error)
                            ->withInput();
                }
                DB::commit();
            } catch(Exception $e) {
                DB::rollBack();
                $error = ['images' => $e->getMessage()];
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
        $mbAcounts->instagram = $request->get('mb_instagram');

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
    
}