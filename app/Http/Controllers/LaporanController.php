<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Carbon\Carbon;
use App\Models\Akun;
use App\Models\Bukukas;
use App\Models\Kategori;
use App\Models\Total;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\JurnalExport;
use App\Models\KategoriAkun;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function pilihjurnal()
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }

        $year = Carbon::now()->format('Y');
        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ', $nama);
        $forename = $pecah[0];
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }

        $month = Keuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $year2 = Keuangan::select(DB::raw('YEAR(tanggal) year2'))->groupBy('year2')->get();
        return view('laporan.pilihjurnal', [
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
            'month' => $month,
            'year2' => $year2
        ]);
    }

    public function jurnal(Request $request)
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }
        if($request->bulan != 'all'){
            $month = date('m', strtotime($request->bulan));
            $month2 = date('F', strtotime($request->bulan));  
        }
        else{
            $month2 = "";
        }
        $year = Carbon::now()->format('Y');
        $year2 = $request->tahun;
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
            'bulan'   => 'required',
            'tahun'   => 'required'
        ]);

        $kredit = Keuangan::where('status','Kredit')->sum('total');
        $debit = Keuangan::where('status', 'Debit')->sum('total');

        if ($request->bulan == 'all' && $request->tahun == 'all') {
            $keuangan = Keuangan::get();
        } elseif ($request->bulan == 'all' && $request->tahun != 'all') {
            $keuangan = Keuangan::whereYear('tanggal', $request->tahun)->get();
        } elseif ($request->bulan != 'all' && $request->tahun == 'all') {
            $keuangan = Keuangan::whereMonth('tanggal', $month)->get();
        } else {
            $val = Keuangan::whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->get();
            $keuangan = $val;
        }

        return view('laporan.jurnal', [
            'keuangan' => $keuangan,
            'surname' => $surname,
            'forename' => $forename,
            'year' => $year,
            'year2' => $year2,
            'month2' => $month2,
            'kredit' => $kredit,
            'debit' => $debit
        ]);
    }

    public function pilih()
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }

        $year = Carbon::now()->format('Y');
        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ', $nama);
        $forename = $pecah[0];
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }
        $month = Keuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
            ->orderBy('month2',"asc")->get()->unique('month');
        $year2 = Keuangan::select(DB::raw('YEAR(tanggal) year2'))->groupBy('year2')->get();
        $akun = Akun::get();
        return view('laporan.pilih', [
            'akun' => $akun,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
            'month' => $month,
            'year2' => $year2
        ]);
    }

    public function postpilih(Request $request)
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }
        if ($request->bulan != 'all') {
            $month = date('m', strtotime($request->bulan));
            $month2 = date('F', strtotime($request->bulan));
        } else {
            $month2 = "";
        }
        $year = Carbon::now()->format('Y');
        $year2 = $request->tahun;
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
            'bulan'   => 'required',
            'tahun'   => 'required'
        ]);

        $kode = Akun::where('kd_akun', $request->kd_akun)->first();
        $kat = Kategori::get();
        $akun = Akun::get();
        $kas = Bukukas::get();
        $akun2 = Akun::where('id', $kode->id)->first();

        if ($request->bulan=='all' && $request->tahun=='all')
        {
            $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) 
                as dummy cross join keuangan WHERE akun_id = '$kode->id'");
            $data = Keuangan::where('akun_id', $kode->id)->get();
        }
        elseif ($request->bulan == 'all' && $request->tahun != 'all')
        {
            $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) 
                as dummy cross join keuangan WHERE akun_id = '$kode->id' and Year(tanggal) = '$request->tahun'");
            $data = Keuangan::where('akun_id', $kode->id)->whereYear('tanggal',$request->tahun)->get();
        }
        elseif ($request->bulan != 'all' && $request->tahun == 'all') 
        {
            $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) 
                as dummy cross join keuangan WHERE akun_id = '$kode->id' and Month(tanggal) = '$month'");
            $data = Keuangan::where('akun_id', $kode->id)->whereMonth('tanggal', $month)->get();
        }
        else
        {
            $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) 
                as dummy cross join keuangan WHERE akun_id = '$kode->id' and Year(tanggal) = '$request->tahun' 
                and Month(tanggal) = '$month'");
            $val = Keuangan::where('akun_id', $kode->id)->whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->get();
            $data = $val;
        }

        return view('laporan.view', [
            'data' => $data,
            'akun' => $akun,
            'kas' => $kas,
            'kat' => $kat,
            'akun2' => $akun2,
            'saldo' => $saldo,
            'surname' => $surname,
            'forename' => $forename,
            'year' => $year,
            'year2' => $year2,
            'month2' => $month2
        ]);
    }

    public function pilih2()
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }

        $year = Carbon::now()->format('Y');
        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ', $nama);
        $forename = $pecah[0];
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }

        $month = Keuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $year2 = Keuangan::select(DB::raw('YEAR(tanggal) year2'))->groupBy('year2')->get();
        $kas = Bukukas::get();
        return view('laporan.pilih2', [
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
            'year2' => $year2,
            'month' => $month
        ]);
    }

    public function postpilih2(Request $request)
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }
        if ($request->bulan != 'all') {
            $month = date('m', strtotime($request->bulan));
            $month2 = date('F', strtotime($request->bulan));
        } else {
            $month2 = "";
        }
        $year = Carbon::now()->format('Y');
        $year2 = $request->tahun;
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
            'bk_kas' => 'required|exists:bukukas',
            'bulan'   => 'required',
            'tahun'   => 'required'
        ]);

        $input = Bukukas::where('bk_kas', $request->bk_kas)->first();
        $kat = Kategori::get();
        $akun = Akun::get();
        $kas = Bukukas::get();
        $data = Keuangan::where('kas_id', $input->id)->get();
        $kas2 = Bukukas::where('id', $input->id)->first();

        if ($request->bulan == 'all' && $request->tahun == 'all') {
            $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) 
                as dummy cross join keuangan WHERE kas_id = '$input->id'");
            $data = Keuangan::where('kas_id', $input->id)->get();
        } elseif ($request->bulan == 'all' && $request->tahun != 'all') {
            $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) 
                as dummy cross join keuangan WHERE kas_id = '$input->id' and Year(tanggal) = '$request->tahun'");
            $data = Keuangan::where('kas_id', $input->id)->whereYear('tanggal', $request->tahun)->get();
        } elseif ($request->bulan != 'all' && $request->tahun == 'all') {
            $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) 
                as dummy cross join keuangan WHERE kas_id = '$input->id' and Month(tanggal) = '$month'");
            $data = Keuangan::where('kas_id', $input->id)->whereMonth('tanggal', $month)->get();
        } else {
            $saldo = DB::select("select id, @b := @b + debit - kredit as saldo from (select @b := 0.0) 
                as dummy cross join keuangan WHERE kas_id = '$input->id' and Year(tanggal) = '$request->tahun' 
                and Month(tanggal) = '$month'");
            $val = Keuangan::where('kas_id', $input->id)->whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->get();
            $data = $val;
        }

        return view('laporan.view2', [
            'data' => $data,
            'akun' => $akun,
            'kas' => $kas,
            'kat' => $kat,
            'kas2' => $kas2,
            'saldo' => $saldo,
            'surname' => $surname,
            'forename' => $forename,
            'year' => $year,
            'year2' => $year2,
            'month2' => $month2
        ]);
    }

    public function pilihnersal()
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }

        $year = Carbon::now()->format('Y');
        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ', $nama);
        $forename = $pecah[0];
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }

        $month = Keuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $year2 = Keuangan::select(DB::raw('YEAR(tanggal) year2'))->groupBy('year2')->get();
        return view('laporan.pilihneraca', [
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
            'month' => $month,
            'year2' => $year2
        ]);
    }

    public function nersal(Request $request)
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }
        if ($request->bulan != 'all') {
            $month = date('m', strtotime($request->bulan));
            $month2 = date('F', strtotime($request->bulan));
        } else {
            $month2 = "";
        }
        $year = Carbon::now()->format('Y');
        $year2 = $request->tahun;
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
            'bulan'   => 'required',
            'tahun'   => 'required'
        ]);

        if ($request->bulan == 'all' && $request->tahun == 'all') {
            $data = Akun::orderBy('kd_akun', 'ASC')->get();
            $saldo = Akun::leftjoin('keuangan', 'akun.id', '=', 'keuangan.akun_id')
                    ->select('kd_akun', DB::raw('sum(total) as sum'))
                    ->groupBy('kd_akun')->get();
            $total = Akun::leftjoin('keuangan', 'akun.id', '=', 'keuangan.akun_id')
                    ->select('posisi',DB::raw('sum(total) as sum'))
                    ->groupBy('posisi')->get();
            $kategori = KategoriAkun::orderBy('kode', 'ASC')->get();
        } 
        elseif ($request->bulan == 'all' && $request->tahun != 'all') {
            $data = Akun::get();
            $saldo = Akun::leftjoin('keuangan', 'akun.id', '=', 'keuangan.akun_id')
                ->select('kd_akun', DB::raw('sum(total) as sum', "where Year(tanggal) = '$request->tahun'"))
                ->groupBy('kd_akun')->get();
            $debit = Keuangan::where('status', 'debit')->whereYear('tanggal',$request->tahun)->sum('total');
            $kredit = Keuangan::where('status', 'kredit')->sum('total');
            $kategori = KategoriAkun::get();
        } 
        elseif ($request->bulan != 'all' && $request->tahun == 'all') {
            $data = Akun::get();
            $saldo = Akun::leftjoin('keuangan', 'akun.id', '=', 'keuangan.akun_id')
                ->select('kd_akun', DB::raw('sum(total) as sum', "where Month(tanggal) = '$month'"))
                ->groupBy('kd_akun')->get();
            $debit = Keuangan::where('status', 'debit')->whereMonth('tanggal', $month)->sum('total');
            $kredit = Keuangan::where('status', 'kredit')->sum('total');
            $kategori = KategoriAkun::get();
        } 
        else {
            $data = Akun::get();
            $saldo = Akun::leftjoin('keuangan', 'akun.id', '=', 'keuangan.akun_id')
            ->select('kd_akun', DB::raw('sum(total) as sum', "where Month(tanggal) = '$month' and Year(tanggal) = '$request->tahun'"))
            ->groupBy('kd_akun')->get();
            $debit = Keuangan::where('status', 'debit')->whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->sum('total');
            $kredit = Keuangan::where('status', 'kredit')->sum('total');
            $kategori = KategoriAkun::get();
        }

        return view('laporan.nersal', [
            'data' => $data,
            'kategori' => $kategori,
            'saldo' => $saldo,
            'surname' => $surname,
            'forename' => $forename,
            'year' => $year,
            'year2' => $year2,
            'month2' => $month2,
            'total' => $total,
        ]);
    }

    public function export()
    {
        return Excel::download(new JurnalExport, 'jurnal.xlsx');
    }
}
