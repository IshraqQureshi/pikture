<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['event_id', 'photo'];

    protected $searchableFields = ['*'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
