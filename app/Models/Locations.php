<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $table = 'branches';
    protected $guarded = [];
    use HasFactory;
}
