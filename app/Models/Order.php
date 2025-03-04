<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    protected $guarded = [];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function details(): HasOne
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function setTravelTimeAttribute($value): void
    {
        $this->attributes['travel_time'] = $this->convertTime($value);
    }

    public function setMeetingTimeAttribute($value): void
    {
        $this->attributes['meeting_time'] = $this->convertTime($value);
    }

    public function getMeetingTimeAttribute($value): string
    {
       return $this->convertTimeToHI($value);
    }

    public function setMeetingDateAttribute($value): void
    {
        $this->attributes['meeting_date'] = $this->convertDate($value);
    }

    public function getMeetingDateAttribute($value): string
    {
       return $this->convertDateToDDMMYYYY($value);
    }

    private function convertTime($value)
    {
        return date('H:i:s', strtotime($value));
    }


    private function convertDate($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    private function convertDateToDDMMYYYY($value)
    {
        return date('d.m.Y', strtotime($value));

    }

    private function convertTimeToHI($value)
    {
        return date('H:i', strtotime($value));
    }


    public function scopeLatest($query)
    {
        return $query->orderBy('id', 'desc');
    }

}
