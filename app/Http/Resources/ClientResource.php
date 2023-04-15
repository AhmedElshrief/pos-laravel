<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'client_id' => $this->id,
            'full_name' => $this->name,
            'mobile' => $this->phone,
            'address' => $this->address,
//            'author' => '3Nany', // meta data
        ];
//        return parent::toArray($request);
    }
}
