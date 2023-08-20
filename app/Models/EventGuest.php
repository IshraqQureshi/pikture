<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

class EventGuest extends Model {

    protected $fillable = [
        'guest_id',
        'event_id',
    ];


    public function events()
    {
        return $this->belongsTo(Event::class);
    }

    public function guests()
    {
        return $this->belongsTo(User::class);
    }
}