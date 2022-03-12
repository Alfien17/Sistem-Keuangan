<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKeuangan extends Model
{
    protected $table = "tbl_keuangan";
    protected $fillable = ['kode', 'status', 'tanggal', 'ket1', 'ket2', 'debit', 'kredit', 'total', 'image', 'kas_id', 'kategori_id','akun_id','hubungan'];

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
