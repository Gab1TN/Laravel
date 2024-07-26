<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }


public function sendEmail(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'message' => 'required|string',
    ]);

    $data = $request->only('name', 'email', 'message');

    Mail::to('gabin.tournier25@gmail.com')->send(new ContactMail($data));

    return redirect()->route('contact.showForm')->with('success', 'Message envoyé avec succès!');
}

}
