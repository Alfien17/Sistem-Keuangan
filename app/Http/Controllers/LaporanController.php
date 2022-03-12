<?php

namespace App\Http\Controllers;

use App\Models\DataKeuangan;
use Carbon\Carbon;
use App\Models\Akun;
use App\Models\Bukukas;
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

        $month = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $year2 = DataKeuangan::select(DB::raw('YEAR(tanggal) year2'))->groupBy('year2')->get();

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

        if ($request->bulan == 'all' && $request->tahun == 'all') {
            $keuangan = DataKeuangan::get();
            $total_d = DataKeuangan::where('status','debit')->sum('total');
            $total_k = DataKeuangan::where('status', 'kredit')->sum('total');
        } elseif ($request->bulan == 'all' && $request->tahun != 'all') {
            $keuangan = DataKeuangan::whereYear('tanggal', $request->tahun)->get();
            $total_d = DataKeuangan::where('status', 'debit')->whereYear('tanggal', $request->tahun)->sum('total');
            $total_k = DataKeuangan::where('status', 'kredit')->whereYear('tanggal', $request->tahun)->sum('total');
        } elseif ($request->bulan != 'all' && $request->tahun == 'all') {
            $keuangan = DataKeuangan::whereMonth('tanggal', $month)->get();
            $total_d = DataKeuangan::where('status', 'debit')->whereMonth('tanggal', $month)->sum('total');
            $total_k = DataKeuangan::where('status', 'kredit')->whereMonth('tanggal', $month)->sum('total');
        } else {
            $val = DataKeuangan::whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->get();
            $total_d = DataKeuangan::where('status', 'debit')->whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->sum('total');
            $total_k = DataKeuangan::where('status', 'kredit')->whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->sum('total');
            $keuangan = $val;
        }

        return view('laporan.jurnal', [
            'keuangan' => $keuangan,
            'surname' => $surname,
            'forename' => $forename,
            'year' => $year,
            'year2' => $year2,
            'month2' => $month2,
            'total_d' => $total_d,
            'total_k' => $total_k,
        ]);
    }

    public function pilihakun()
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
        
        $month = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
            ->orderBy('month2',"asc")->get()->unique('month');
        $year2 = DataKeuangan::select(DB::raw('YEAR(tanggal) year2'))->groupBy('year2')->get();
        $akun = Akun::orderBy('kd_akun', 'ASC')->get();

        return view('laporan.pilihakun', [
            'akun' => $akun,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
            'month' => $month,
            'year2' => $year2
        ]);
    }

    public function postpilihakun(Request $request)
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

        if ($request->bulan=='all' && $request->tahun=='all')
        {
            $saldo = DB::select("SELECT id, @b := @b + debit - kredit AS saldo FROM (SELECT @b := 0.0) 
                AS dummy CROSS JOIN tbl_keuangan WHERE akun_id = '$kode->id'");
            $data = DataKeuangan::where('akun_id', $kode->id)->get();
        }
        elseif ($request->bulan == 'all' && $request->tahun != 'all')
        {
            $saldo = DB::select("SELECT id, @b := @b + debit - kredit AS saldo FROM (SELECT @b := 0.0) 
                AS dummy CROSS JOIN tbl_keuangan WHERE akun_id = '$kode->id' AND YEAR(tanggal) = '$request->tahun'");
            $data = DataKeuangan::where('akun_id', $kode->id)->whereYear('tanggal',$request->tahun)->get();
        }
        elseif ($request->bulan != 'all' && $request->tahun == 'all') 
        {
            $saldo = DB::select("SELECT id, @b := @b + debit - kredit AS saldo FROM (SELECT @b := 0.0) 
                AS dummy CROSS JOIN tbl_keuangan WHERE akun_id = '$kode->id' AND MONTH(tanggal) = '$month'");
            $data = DataKeuangan::where('akun_id', $kode->id)->whereMonth('tanggal', $month)->get();
        }
        else
        {
            $saldo = DB::select("SELECT id, @b := @b + debit - kredit AS saldo FROM (SELECT @b := 0.0) 
                AS dummy CROSS JOIN tbl_keuangan WHERE akun_id = '$kode->id' AND YEAR(tanggal) = '$request->tahun' AND MONTH(tanggal) = '$month'");
            $val = DataKeuangan::where('akun_id', $kode->id)->whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->get();
            $data = $val;
        }

        return view('laporan.bukuakun', [
            'data' => $data,
            'saldo' => $saldo,
            'surname' => $surname,
            'forename' => $forename,
            'year' => $year,
            'year2' => $year2,
            'month2' => $month2,
            'kode' => $kode
        ]);
    }

    public function pilihbkkas()
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

        $month = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $year2 = DataKeuangan::select(DB::raw('YEAR(tanggal) year2'))->groupBy('year2')->get();
        $kas = Bukukas::orderBy('bk_kas', 'ASC')->get();
        return view('laporan.pilihbkkas', [
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
            'year2' => $year2,
            'month' => $month
        ]);
    }

    public function postpilihbkkas(Request $request)
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

        if ($request->bulan == 'all' && $request->tahun == 'all') {
            $saldo = DB::select("SELECT id, @b := @b + debit - kredit AS saldo FROM (SELECT @b := 0.0) 
                AS dummy CROSS JOIN tbl_keuangan WHERE kas_id = '$input->id'");
            $data = DataKeuangan::where('kas_id', $input->id)->get();
        } elseif ($request->bulan == 'all' && $request->tahun != 'all') {
            $saldo = DB::select("SELECT id, @b := @b + debit - kredit AS saldo FROM (SELECT @b := 0.0) 
                AS dummy CROSS JOIN tbl_keuangan WHERE kas_id = '$input->id' AND YEAR(tanggal) = '$request->tahun'");
            $data = DataKeuangan::where('kas_id', $input->id)->whereYear('tanggal', $request->tahun)->get();
        } elseif ($request->bulan != 'all' && $request->tahun == 'all') {
            $saldo = DB::select("SELECT id, @b := @b + debit - kredit AS saldo FROM (SELECT @b := 0.0) 
                AS dummy CROSS JOIN tbl_keuangan WHERE kas_id = '$input->id' AND MONTH(tanggal) = '$month'");
            $data = DataKeuangan::where('kas_id', $input->id)->whereMonth('tanggal', $month)->get();
        } else {
            $saldo = DB::select("SELECT id, @b := @b + debit - kredit AS saldo FROM (SELECT @b := 0.0) 
                AS dummy CROSS JOIN tbl_keuangan WHERE kas_id = '$input->id' AND YEAR(tanggal) = '$request->tahun' 
                AND MONTH(tanggal) = '$month'");
            $val = DataKeuangan::where('kas_id', $input->id)->whereYear('tanggal', $request->tahun)->whereMonth('tanggal', $month)->get();
            $data = $val;
        }

        return view('laporan.bukukas', [
            'data' => $data,
            'saldo' => $saldo,
            'surname' => $surname,
            'forename' => $forename,
            'year' => $year,
            'year2' => $year2,
            'month2' => $month2,
            'input' => $input
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

        $month = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $year2 = DataKeuangan::select(DB::raw('YEAR(tanggal) year2'))->groupBy('year2')->get();
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
            $saldo = DB::select("SELECT kd_akun, SUM(total) as sum FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
                GROUP BY(kd_akun)");
            $total = DB::select("SELECT posisi, SUM(total) as sum FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
                GROUP BY(posisi)");
            $kategori = KategoriAkun::orderBy('kode', 'ASC')->get();
        } 
        elseif ($request->bulan == 'all' && $request->tahun != 'all') {
            $data = Akun::orderBy('kd_akun', 'ASC')->get();
            $saldo = DB::select("SELECT kd_akun, SUM(total) as sum FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
                WHERE YEAR(tanggal) = '$request->tahun' GROUP BY(kd_akun)");
            $total = DB::select("SELECT posisi, SUM(total) as sum FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
                WHERE YEAR(tanggal) = '$request->tahun' GROUP BY(posisi)");
            $kategori = KategoriAkun::orderBy('kode', 'ASC')->get();
        } 
        elseif ($request->bulan != 'all' && $request->tahun == 'all') {
            $data = Akun::orderBy('kd_akun', 'ASC')->get();
            $saldo = DB::select("SELECT kd_akun, SUM(total) as sum FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
                WHERE MONTH(tanggal) = '$month' GROUP BY(kd_akun)");
            $total = DB::select("SELECT posisi, SUM(total) as sum FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
                WHERE MONTH(tanggal) = '$month' GROUP BY(posisi)");
            $kategori = KategoriAkun::orderBy('kode', 'ASC')->get();
        } 
        else {
            $data = Akun::orderBy('kd_akun', 'ASC')->get();
            $saldo = DB::select("SELECT kd_akun, SUM(total) as sum FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
                WHERE MONTH(tanggal) = '$month' and YEAR(tanggal) = '$request->tahun' GROUP BY(kd_akun)");
            $total = DB::select("SELECT posisi, SUM(total) as sum FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
                WHERE MONTH(tanggal) = '$month' and YEAR(tanggal) = '$request->tahun' GROUP BY(posisi)");
            $kategori = KategoriAkun::orderBy('kode', 'ASC')->get();
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

    // public function export()
    // {
    //     return Excel::download(new JurnalExport, 'jurnal.xlsx');
    // }
}
