<?php

namespace App\Http\Controllers;

use App\Events\ContactSubmited;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request, Contact $contact)
    {
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email",
            "subject" => "required",
            "content" => "required"
        ]);

        $contact = $contact->newQuery()->create($request->only(["name", "email", "subject", "content"]));

        event(new ContactSubmited($contact));

        return response()->success();
    }
}
