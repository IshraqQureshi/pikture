<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['email', 'event_id'];

    protected $searchableFields = ['*'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
