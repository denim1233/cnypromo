<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $table = 'carts';
    protected $guarded = [];
    use HasFactory;
}
