<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Contact::class);

        return request()->user()->contacts;
    }

    public function store()
    {
        $this->authorize('viewAny', Contact::class);

        request()->user()->contacts()->create($this->getValidate());
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return $contact;
    }

    public function update(Contact $contact)
    {
        $this->authorize('view', $contact);

        $contact->update($this->getValidate());
    }


    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

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
