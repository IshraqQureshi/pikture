<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\ThankyouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        return view('app.contact.index');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'full_name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        Mail::to('admin@admin.com')->send(new ContactMail($request->full_name, $request->email, $request->message));
        Mail::to($request->email)->send(new ThankyouMail($request->full_name));

        return redirect()
            ->route('contact')
            ->withSuccess(__('crud.contact.send'));

        return view('app.contact.index');
    }
}
