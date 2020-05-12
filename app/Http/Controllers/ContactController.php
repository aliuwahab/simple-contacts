<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return request()->user()->contacts;
    }

    public function store()
    {
        request()->user()->contacts()->create($this->getValidate());
    }

    public function show(Contact $contact)
    {
        if (request()->user()->isNot($contact->user)) {
            return response([], 403);
        }
        return $contact;
    }

    public function update(Contact $contact)
    {
        if (request()->user()->isNot($contact->user)) {
            return response([], 403);
        }

        $contact->update($this->getValidate());
    }


    public function destroy(Contact $contact)
    {
        if (request()->user()->isNot($contact->user)) {
            return response([], 403);
        }

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
