<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'total_price'=>$this->total_price,
            'address_from'=>$this->address_from,
            'address_to'=>$this->address_to,
            'meeting_date'=>$this->meeting_date,
            'adults'=>$this->adults,
            'suitcases'=>$this->suitcases,
            'client'=>new ClientResource($this->client)
        ];
    }
}
