<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'contact_id' => $this->id,
                'full_name' => $this->first_name . ' ' . $this->other_names . ' ' . $this->last_name,
                'birth_date' => $this->birth_date->format('Y-m-d'),
                'added_on' => $this->created_at->toDateString(),
                'last_updated' => $this->updated_at->diffForHumans(),
                'company' => $this->company,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
            ],
            'links' => [
                'self'=> $this->path()
            ]
        ];
    }

}
