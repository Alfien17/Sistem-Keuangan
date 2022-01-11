<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
     protected $table = "kategori";
     protected $fillable = ['name'];

     public function keuangan()
     {
          return $this->hasOne('App\Models\Keuangan');
     }
}
