<?php 


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model{

    protected $fillable = [
        'cart_id',
        'photo_id',
        'print_option',
        'price',
        'quantity',
    ];

    protected $table = 'cart_item';

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function printOption()
    {
        return $this->belongsTo(PrintOption::class, 'print_option', 'id');
    }
}