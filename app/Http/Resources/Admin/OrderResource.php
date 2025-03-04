<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\StatusResource;
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
            'meeting_date_formatted'=>date('Y-m-d', strtotime($this->meeting_date)),
            'meeting_time'=>$this->meeting_time,
            'adults'=>$this->adults,
            'comment'=>$this->comment,
            'suitcases'=>$this->suitcases,
            'status'=>new StatusResource($this->status),
            'client'=>new ClientResource($this->client)
        ];
    }
}
