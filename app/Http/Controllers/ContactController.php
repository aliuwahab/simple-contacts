<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store()
    {
        Contact::create($this->getValidate());
    }

    public function show(Contact $contact)
    {
        return $contact;
    }

    public function update(Contact $contact)
    {
        $contact->update($this->getValidate());
    }


    public function destroy(Contact $contact)
    {
        $contact->delete();
    }

    /**
     * @return array
     */
    private function getValidate(): array
    {
        return request()->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'birth_date' => 'required',
                'phone_number' => 'required|unique:users,phone_number'
            ]
        );
    }
}
