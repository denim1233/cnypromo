<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items';
    protected $guarded = [];
    use HasFactory;

    // public function importToDb()
    // {
    //     $path = resource_path('pending-files/*.csv');

    //     $g = glob($path);

    //     foreach (array_slice($g, 0, 1) as $file) {

    //         $data = array_map('str_getcsv', file($file));

    //         foreach ($data as $row) {
    //             self::updateOrCreate([
    //                 ''
    //             ]);
    //         }
    //     }
    // }
}
