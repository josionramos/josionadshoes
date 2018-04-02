<?php

namespace App\Http\Controllers;

use App\Mail\FormContact;
use App\Http\Requests\ContactForm as Request;

use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{

    /**
     * Send contact form by e-mail.
     *
     * @param  Request $request
     */
    public function send(Request $request)
    {
        Mail::to(config('mail.from.address'))->send(new FormContact($request->all()));
    }
}
