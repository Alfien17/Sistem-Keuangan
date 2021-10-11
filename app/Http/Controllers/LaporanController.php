<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Total;
use App\Models\Akun;
use App\Models\Bukukas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function jurnal()
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }

        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ', $nama);
        $forename = $pecah[0];
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }

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
            'akun' => $akun,
            'surname' => $surname,
            'forename' => $forename
        ]);
    }

    public function pilih()
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }

        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ', $nama);
        $forename = $pecah[0];
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }

        $akun = Akun::get();
        return view('laporan.pilih', [
            'akun' => $akun,
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    public function postpilih(Request $request)
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }

        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ', $nama);
        $forename = $pecah[0];
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }

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
            'saldo' => $saldo,
            'surname' => $surname,
            'forename' => $forename
        ]);
    }
}
