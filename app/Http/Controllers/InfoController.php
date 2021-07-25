<?php

namespace App\Http\Controllers;

use App\Mail\AdminContact;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InfoController extends Controller
{
    public function index() {
        $services = Service::where('principal_page', '=', true)->get();
        return view('Web/index', ['services' => $services]);
    }

    public function about() {
        return view('Web/Info/about');
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
