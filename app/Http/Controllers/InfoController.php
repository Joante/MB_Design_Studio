<?php

namespace App\Http\Controllers;

use App\Mail\AdminContact;
use App\Mail\ContactMail;
use App\Models\Acounts;
use App\Models\ArtColection;
use App\Models\ArtExhibition;
use App\Models\Contact;
use App\Models\Image;
use App\Models\Information;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InfoController extends Controller
{
    public function index() {
        $services = Service::where('principal_page', '=', true)->limit(4)->get();
        $projects = Project::where('principal_page', '=', true)->limit(6)->get();
        $posts = Post::where('principal_page', '=', true)->limit(4)->get();
        $exhibitions = ArtExhibition::where('principal_page', '=', true)->limit(2)->get();
        $colections = ArtColection::where('principal_page', '=', true)->limit(4)->get();
        $homepageImages = Image::where('model_type', 'App\\Models\\HomepageImage')->orderBy('hierarchy')->get();
        $about = Information::first();

        foreach ($posts as $post) {
            $post['created'] = $post['created'] = $post->created_at->format('d/m/Y');
        }

        return view('Web/index', ['homepageImages' => $homepageImages, 'services' => $services, 'projects' => $projects, 'posts' => $posts, 'exhibitions' => $exhibitions, 'colections' => $colections, 'about' => $about]);
    }

    public function about() {
        $location = Image::where('model_type', '=', 'App\Models\User')->where('model_id', '=', 1)->value('location');
        if(!$location) {
            $location = 'img/600x600.jpg';
        }
        $description = User::where('id', '=', 1)->value('description');
        $perAcounts = Acounts::where('type', '=', 'personal')->first();
        $about = Information::first();
        $aboutText = $about != null ? $about->about : '';
        return view('Web/Info/about', ['location' => $location, 'perAcounts' => $perAcounts, 'description' => $description, 'about' => $aboutText]);
    }

    public function update_about(Request $request){
        $request->validate([
            'about' => 'required',
        ]);
        $about = Information::first();

        if(!$about){
            $about = new Information($request->all());
        }else {
            $about->about = $request->get('about');
        }
        if(!$about->save()){
            $error = ['error' => 'Problemas al actualizar el texto'];
            return redirect('admin/settings')
                ->withErrors($error)
                ->withInput();
        }

        return redirect()->route('admin_edit'); 
    }

    public function contact() {
        return view('Web/Info/contact');
    }

    public function storeContact(Request $request) {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:500',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $input = $request->all();
        $contact = Contact::create($input);


        //  Send mail to admin
        Mail::to(config('mail.from.address'))
            ->queue(new AdminContact($contact));

        // Send mail to client 
        Mail::to($request->get('email'))
            ->queue(new ContactMail($request->get('name')));


        return redirect()->back()->with(['success' => 'Mensaje enviado']);

    }
}
