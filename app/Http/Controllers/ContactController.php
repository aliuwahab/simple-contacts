<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Contact::class);

        return ContactResource::collection(request()->user()->contacts);
    }

    public function store()
    {
        $this->authorize('viewAny', Contact::class);

        $contact = request()->user()->contacts()->create($this->getValidate());

        return (new ContactResource($contact))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return (new ContactResource($contact));
    }

    public function update(Contact $contact)
    {
        $this->authorize('view', $contact);

        $contact->update($this->getValidate());

        return (new ContactResource($contact))->response()->setStatusCode(Response::HTTP_OK);
    }


    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return \response([], Response::HTTP_NO_CONTENT);
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
