<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchContacts()
    {
        $data = request()->validate(['search_term' => 'required']);
        $searchMatches = Contact::search($data['search_term'])->where('user_id', request()->user()->id)->get();

        return ContactResource::collection($searchMatches);
    }
}
