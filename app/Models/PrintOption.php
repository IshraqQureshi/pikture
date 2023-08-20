<?php 


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintOption extends Model{

    protected $fillable = [
        'print_type',
        'paper_type',
        'packaging',
        'price',        
    ];

    protected $table = 'print_option';

}