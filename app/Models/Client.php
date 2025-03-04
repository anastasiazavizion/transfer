<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use Notifiable;


    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'preferred_messenger_id'];


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    public function messenger(): BelongsTo
    {
        return $this->belongsTo(Messenger::class, 'preferred_messenger_id');
    }
}
