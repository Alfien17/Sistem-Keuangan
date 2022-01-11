<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = "keuangan";
    protected $fillable = ['status','tanggal','ket','debit','kredit','total','saldo','image','akun_id', 'kas_id', 'kategori_id',];

    public function akun()
    {
        return $this->belongsTo('App\Models\Akun');
    }

    public function kas()
    {
        return $this->belongsTo('App\Models\Bukukas');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori');
    }
}
