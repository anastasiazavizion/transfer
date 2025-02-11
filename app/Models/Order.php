<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{

    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function status() : BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function details() : HasOne
    {
        return $this->hasOne(OrderDetail::class);
    }

}
