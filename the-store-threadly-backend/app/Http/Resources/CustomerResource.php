<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user->id,
	        'name' => $this->user->name,
	        'email' => $this->user->email,
	        'image' => $this->getImage(),
	        'phone' => $this->phone,
	        'country' => $this->country,
	        'state' => $this->state,
	        'city' => $this->city,
	        'zip' => $this->zip,
	        'address' => $this->address,
	    ];
    }
}
