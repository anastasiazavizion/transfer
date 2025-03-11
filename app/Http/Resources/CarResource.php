<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CarResource extends JsonResource
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
            'name'=>$this->name,
            'type'=>$this->carType->name,
            'max_people_amount'=>$this->max_people_amount,
            'max_suitcase_amount'=>$this->max_suitcase_amount,
            'image'=>Storage::disk('public')->url($this->image),
        ];
    }
}
