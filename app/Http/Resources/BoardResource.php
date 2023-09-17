<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' =>$this->firstName,
            'lastName' =>$this->lastName,
            'fullName' => $this->firstName .' '.$this->lastName,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'position' => $this->position,
            'photo' => asset('storage/images/board-members/' . $this->photo),
        ];
    }
}
