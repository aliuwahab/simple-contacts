<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'first_name' => 'required',
                                        'last_name' => 'required',
                                        'email' => 'required|email|unique:users,email',
                                        'birth_date' => 'required',
                                        'phone_number' => 'required|unique:users,phone_number'
                                    ]);

//        dd($data);
        Contact::create($data);
    }
}
