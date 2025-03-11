<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    protected $fillable = ['name', 'image', 'petrol_consumption'];

    public function carType() : BelongsTo{
        return $this->belongsTo(CarType::class);
    }
}
