<?php

namespace App\Http\Controllers;

use App\Mail\AdminContact;
use App\Mail\ContactMail;
use App\Models\Acounts;
use App\Models\Contact;
use App\Models\Image;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InfoController extends Controller
{
    public function index() {
        $services = Service::where('principal_page', '=', true)->limit(3)->get();
        $projects = Project::where('principal_page', '=', true)->limit(6)->get();
        $posts = Post::where('principal_page', '=', true)->limit(4)->get();

        foreach ($posts as $post) {
            $post['created'] = $post['created'] = $post->created_at->format('d/m/Y');
        }

        return view('Web/index', ['services' => $services, 'projects' => $projects, 'posts' => $posts]);
    }

    public function about() {
        $location = Image::where('model_type', '=', 'App\Models\User')->where('model_id', '=', 1)->value('location');
        if(!$location) {
            $location = 'img/600x600.jpg';
        }
        $description = User::where('id', '=', 1)->value('description');
        $perAcounts = Acounts::where('type', '=', 'personal')->first();
        return view('Web/Info/about', ['location' => $location, 'perAcounts' => $perAcounts, 'description' => $description]);
    }

    public function contact() {
        return view('Web/Info/contact');
    }

    public function prueba() {
        return view('Web/Emails/contactMailAdmin', ['name' => 'Joan Teich', 'email' => 'joanteich@gmail.com', 'messages' => 'Hola como estas. todo bien?']);
    }

    public function storeContact(Request $request) {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:500'
        ]);

        $input = $request->all();
        $contact = Contact::create($input);


        //  Send mail to admin
        Mail::to('joanteich@gmail.com')->queue(new AdminContact($contact));

        // Send mail to client 
        Mail::to($request->get('email'))->queue(new ContactMail($request->get('name')));


        return redirect()->back()->with(['success' => 'Mensaje enviado']);

    }
}
