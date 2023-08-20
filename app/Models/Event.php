<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'gallery_name',
        'max_photos',
        'max_users',
        'expiration_date',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
    public function getPhotoCountAttribute()
    {
        return $this->photos()->count();
    }
}
