<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'subject' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        Mail::to('tpineiro@truckts.com')->bcc('dani.rg15@gmail.com')->queue(new ContactMail($data));

        return redirect('/#contact')->with('success_message', 'Mensaje enviado. En breve nos pondrémos en contacto contigo.');
    }
}
