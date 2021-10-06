<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Total;
use App\Models\Akun;
use App\Models\Bukukas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function jurnal()
    {
        $keuangan = Keuangan::get();
        $kat = Kategori::get();
        $akun = Akun::get();
        $kas = Bukukas::get();
        $saldo = Keuangan::sum('total');

        return view('laporan.jurnal', [
            'keuangan' => $keuangan,
            'saldo' => $saldo,
            'kat' => $kat,
            'kas' => $kas,
            'akun' => $akun
        ]);
    }

    public function pilih()
    {
        $akun = Akun::get();
        return view('laporan.pilih', ['akun' => $akun]);
    }

    public function postpilih(Request $request)
    {
        $this->validate($request, [
            'kd_akun' => 'required|exists:akun',
        ]);

        $kode = Akun::where('kd_akun', $request->kd_akun)->first();
        $kat = Kategori::get();
        $akun = Akun::get();
        $kas = Bukukas::get();
        $data = Keuangan::where('akun_id',$kode->id)->get();
        $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) as dummy cross join keuangan WHERE akun_id = '$kode->id'");
        $akun2 = Akun::where('id', $kode->id)->first();

        return view('laporan.view', [
            'data' => $data,
            'akun' => $akun,
            'kas' => $kas,
            'kat' => $kat,
            'akun2' => $akun2,
            'saldo' => $saldo
        ]);
    }
}
