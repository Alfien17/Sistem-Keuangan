<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bukukas extends Model
{
    protected $table = "bukukas";
    protected $fillable = ['bk_kas', 'tipe'];

    public function keuangan()
    {
        return $this->hasOne('App\Models\Keuangan');
    }
}
