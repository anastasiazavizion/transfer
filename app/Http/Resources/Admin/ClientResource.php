<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\MessengerResource;
use App\Models\Messenger;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'messenger'=>new MessengerResource($this->messenger)
        ];
    }
}
