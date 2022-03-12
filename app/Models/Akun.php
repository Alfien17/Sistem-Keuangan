<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = "akun";
    protected $fillable = ['nama_akun','kd_akun','posisi','katakun_id','tipe'];

    public function keuangan()
    {
        return $this->hasOne('App\Models\Keuangan');
    }

    public function total()
    {
        return $this->hasOne('App\Models\Total');
    }

    public function katakun()
    {
        return $this->belongsTo('App\Models\KategoriAkun');
    }
    
}
