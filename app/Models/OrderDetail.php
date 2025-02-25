<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{

    protected $fillable = [
        'order_id', 'km_to_location_1', 'km_to_location_2', 'km_back',
        'price_per_km_when_empty', 'price_per_km_with_client'
    ];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);

    }

    public function setKmToLocation1Attribute($value): void
    {

        $this->attributes['km_to_location_1'] = $this->convertKm($value);
    }

    public function setKmToLocation2Attribute($value): void
    {
        $this->attributes['km_to_location_2'] = $this->convertKm($value);
    }

    public function setKmBackAttribute($value): void
    {
        $this->attributes['km_back'] = $this->convertKm($value);
    }

    private function convertKm($value)
    {
        return (double) preg_replace('/[^0-9.]/', '', $value);
    }

}
