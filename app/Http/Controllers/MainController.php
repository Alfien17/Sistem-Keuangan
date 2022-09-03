<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Akun;
use App\Models\Bukukas;
use App\Models\Kategori;
use App\Models\DataKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function main()
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

        return view('main',[
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function dashboard()
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }
        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ',$nama);
        $forename = $pecah[0];
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }

        $sortakun = Akun::get();

        $juser = User::where('id','!=',1)->count();
        $akun = Akun::get();
        $kas = Bukukas::count();
        $kat = Kategori::count();
        $keu = DataKeuangan::count();
        $countakun = Akun::count();

        $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $year = Carbon::now()->format('Y');
        $sort = DataKeuangan::select(DB::raw('YEAR(tanggal) year'))->groupBy('year')->get();
        $month = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $month2 = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2, YEAR(tanggal) year"))
        ->orderBy('year', "asc")->get();

        $pemasukkan = DataKeuangan::join('akun','akun.id','=','tbl_keuangan.akun_id')->where('tipe','pendapatan')->sum('total');
        $pemasukkan2 = $pemasukkan*-1;
        $biaya = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')->where('tipe', 'biaya')->sum('total');
        $saldo = $pemasukkan2 - $biaya;
        $ratio = $biaya / ($pemasukkan2) *100;

        $chart = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')
            ->select(DB::raw("DATE_FORMAT(tanggal, '%M') month,
            SUM(CASE WHEN tipe = 'pendapatan' THEN total ELSE '0' END*-1) - SUM(CASE WHEN tipe = 'biaya' THEN total ELSE '0' END) total"))
            ->whereYear('tanggal', $year)->groupBy('month')->get();
        $cardrat = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')
            ->select(DB::raw("DATE_FORMAT(tanggal, '%M') month,
            SUM(CASE WHEN tipe = 'biaya' THEN total ELSE '0' END) / SUM(CASE WHEN tipe = 'pendapatan' THEN total ELSE '0' END*-1)*100 ratio"))
            ->groupBy('month')->get();

        $chart2 = DB::select("SELECT kd_akun, SUM(total) as total FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
            WHERE posisi = 'debit' AND YEAR (tanggal) = '$year' GROUP BY(kd_akun)");
        $chart3 = DB::select("SELECT kd_akun, SUM(total) as total FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
            WHERE posisi = 'kredit' AND YEAR (tanggal) = '$year' GROUP BY(kd_akun)");

        return view('dashboard.dashboard', [
            'kas' => $kas,
            'kat' => $kat,
            'keu' => $keu,
            'akun' => $akun,
            'today' => $today,
            'pemasukkan2' => $pemasukkan2,
            'biaya' => $biaya,
            'saldo' => $saldo,
            'ratio' => $ratio,
            'sortakun' => $sortakun,
            'sort' => $sort,
            'year' => $year,
            'forename' => $forename,
            'surname' => $surname,
            'juser' => $juser,
            'month' => $month,
            'month2' => $month2,
            'chart' => $chart,
            'chart2' => $chart2,
            'chart3' => $chart3,
            'cardrat' => $cardrat,
            'countakun' => $countakun
        ]);
    }

    public function sortyear1(Request $request)
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

        $sortakun = Akun::get();

        $juser = User::count();
        $akun = Akun::get();
        $kas = Bukukas::count();
        $kat = Kategori::count();
        $keu = DataKeuangan::count();

        $countakun = Akun::count();

        $pemasukkan = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')->where('tipe', 'pendapatan')->sum('total');
        $pemasukkan2 = $pemasukkan * -1;
        $biaya = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')->where('tipe', 'biaya')->sum('total');
        $saldo = $pemasukkan2 - $biaya;
        $ratio = $biaya / ($pemasukkan2) * 100;

        $cardrat = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')
        ->select(DB::raw("DATE_FORMAT(tanggal, '%M') month,
            SUM(CASE WHEN tipe = 'biaya' THEN total ELSE '0' END) / SUM(CASE WHEN tipe = 'pendapatan' THEN total ELSE '0' END*-1)*100 ratio"))
        ->groupBy('month')->get();

        if(!empty($request->sortir)){
            $year2 = $request->get('sortir');
        }else{
            $year2 = Carbon::now()->format('Y');
        }
        $year = Carbon::now()->format('Y');

        $chart = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')
        ->select(DB::raw("DATE_FORMAT(tanggal, '%M') month,
            SUM(CASE WHEN tipe = 'pendapatan' THEN total ELSE '0' END*-1) - SUM(CASE WHEN tipe = 'biaya' THEN total ELSE '0' END) total"))
        ->whereYear('tanggal',$year2)->groupBy('month')->get();
        $chart2 = DB::select("SELECT kd_akun, SUM(total) as total FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
            WHERE posisi = 'debit' AND YEAR (tanggal) = '$year' GROUP BY(kd_akun)");
        $chart3 = DB::select("SELECT kd_akun, SUM(total) as total FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
            WHERE posisi = 'kredit' AND YEAR (tanggal) = '$year' GROUP BY(kd_akun)");

        $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $year = Carbon::now()->format('Y');
        $sort = DataKeuangan::select(DB::raw('YEAR(tanggal) year'))->groupBy('year')->get();
        $month = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $month2 = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2, YEAR(tanggal) year"))
        ->orderBy('year', "asc")->get();
        return view('dashboard.dashboard', [
            'kas' => $kas,
            'kat' => $kat,
            'akun' => $akun,
            'keu' => $keu,
            'today' => $today,
            'pemasukkan2' => $pemasukkan2,
            'biaya' => $biaya,
            'saldo' => $saldo,
            'ratio' => $ratio,
            'sortakun' => $sortakun,
            'sort' => $sort,
            'year' => $year,
            'year2' => $year2,
            'forename' => $forename,
            'surname' => $surname,
            'juser' => $juser,
            'month' => $month,
            'month2' => $month2,
            'chart' => $chart,
            'chart2' => $chart2,
            'chart3' => $chart3,
            'cardrat' => $cardrat,
            'countakun' => $countakun
        ]);
    }

    public function sortyear2(Request $request)
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

        $sortakun = Akun::get();
        
        $juser = User::count();
        $akun = Akun::get();
        $kas = Bukukas::count();
        $kat = Kategori::count();
        $keu = DataKeuangan::count();

        $countakun = Akun::count();

        $pemasukkan = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')->where('tipe', 'pendapatan')->sum('total');
        $pemasukkan2 = $pemasukkan * -1;
        $biaya = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')->where('tipe', 'biaya')->sum('total');
        $saldo = $pemasukkan2 - $biaya;
        $ratio = $biaya / ($pemasukkan2) * 100;

        $cardin = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')->select(DB::raw("kd_akun, SUM(total)*-1 pendapatan"))
        ->where('tipe', 'pendapatan')->groupBy('kd_akun')->orderBy('pendapatan', 'DESC')->get();
        $cardout = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')->select(DB::raw("kd_akun, SUM(total) biaya"))
        ->where('tipe', 'biaya')->groupBy('kd_akun')->orderBy('biaya', 'DESC')->get();
        $cardrat = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')
        ->select(DB::raw("DATE_FORMAT(tanggal, '%M') month,
            SUM(CASE WHEN tipe = 'biaya' THEN total ELSE '0' END) / SUM(CASE WHEN tipe = 'pendapatan' THEN total ELSE '0' END*-1)*100 ratio"))
        ->groupBy('month')->get();

        if (!empty($request->sortir2)) {
            $year3 = $request->get('sortir2');
        } else {
            $year3 = Carbon::now()->format('Y');
        }
        $year = Carbon::now()->format('Y');

        $chart = DataKeuangan::join('akun', 'akun.id', '=', 'tbl_keuangan.akun_id')
        ->select(DB::raw("DATE_FORMAT(tanggal, '%M') month,
            SUM(CASE WHEN tipe = 'pendapatan' THEN total ELSE '0' END*-1) - SUM(CASE WHEN tipe = 'biaya' THEN total ELSE '0' END) total"))
        ->whereYear('tanggal', $year)->groupBy('month')->get();
        $chart2 = DB::select("SELECT kd_akun, SUM(total) as total FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
            WHERE posisi = 'debit' AND YEAR (tanggal) = '$year3' GROUP BY(kd_akun)");
        $chart3 = DB::select("SELECT kd_akun, SUM(total) as total FROM akun JOIN tbl_keuangan keu ON keu.akun_id = akun.id 
            WHERE posisi = 'kredit' AND YEAR (tanggal) = '$year3' GROUP BY(kd_akun)");

        $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $year = Carbon::now()->format('Y');
        $sort = DataKeuangan::select(DB::raw('YEAR(tanggal) year'))->groupBy('year')->get();
        $month = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2"))
        ->orderBy('month2', "asc")->get()->unique('month');
        $month2 = DataKeuangan::select(DB::raw("DATE_FORMAT(tanggal, '%M') month , MONTH(tanggal) month2, YEAR(tanggal) year"))
        ->orderBy('year', "asc")->get();
        return view('dashboard.dashboard', [
            'kas' => $kas,
            'kat' => $kat,
            'akun' => $akun,
            'keu' => $keu,
            'today' => $today,
            'pemasukkan2' => $pemasukkan2,
            'biaya' => $biaya,
            'saldo' => $saldo,
            'ratio' => $ratio,
            'sortakun' => $sortakun,
            'sort' => $sort,
            'year' => $year,
            'year3' => $year3,
            'forename' => $forename,
            'surname' => $surname,
            'juser' => $juser,
            'month' => $month,
            'month2' => $month2,
            'chart' => $chart,
            'chart2' => $chart2,
            'chart3' => $chart3,
            'cardin' => $cardin,
            'cardout' => $cardout,
            'cardrat' => $cardrat,
            'countakun' => $countakun
        ]);
    }

    public function reset()
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

        return view('reset.resetview',[
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function help()
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

        return view('help.helpview', [
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function pendapatan()
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

        $pendapatan = DataKeuangan::join('akun','tbl_keuangan.akun_id','=','akun.id')->where('tipe','pendapatan')->get();
        $total = DataKeuangan::join('akun', 'tbl_keuangan.akun_id', '=', 'akun.id')->where('tipe', 'pendapatan')->sum('total');
        return view('dashboard.pendapatan',[
            'pendapatan' => $pendapatan,
            'total' => $total,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function postpendapatan (Request $request)
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

        $from = $request->dari;
        $to = $request->ke;

        $pendapatan = DataKeuangan::join('akun', 'tbl_keuangan.akun_id', '=', 'akun.id')->where('tipe', 'pendapatan')
            ->whereBetween('tanggal', [$from, $to])->get();
        $total = DataKeuangan::join('akun', 'tbl_keuangan.akun_id', '=', 'akun.id')->where('tipe', 'pendapatan')
            ->whereBetween('tanggal', [$from, $to])->sum('total');
        return view('dashboard.pendapatan', [
            'pendapatan' => $pendapatan,
            'total' => $total,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
            'from' => $from,
            'to' => $to
        ]);
    }

    public function biaya()
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

        $biaya = DataKeuangan::join('akun', 'tbl_keuangan.akun_id', '=', 'akun.id')->where('tipe', 'biaya')->get();
        $total = DataKeuangan::join('akun', 'tbl_keuangan.akun_id', '=', 'akun.id')->where('tipe', 'biaya')->sum('total');
        return view('dashboard.biaya', [
            'biaya' => $biaya,
            'total' => $total,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function postbiaya(Request $request)
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

        $from = $request->dari;
        $to = $request->ke;

        $biaya = DataKeuangan::join('akun', 'tbl_keuangan.akun_id', '=', 'akun.id')->where('tipe', 'biaya')
        ->whereBetween('tanggal', [$from, $to])->get();
        $total = DataKeuangan::join('akun', 'tbl_keuangan.akun_id', '=', 'akun.id')->where('tipe', 'biaya')
        ->whereBetween('tanggal', [$from, $to])->sum('total');
        return view('dashboard.biaya', [
            'biaya' => $biaya,
            'total' => $total,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
            'from' => $from,
            'to' => $to
        ]);
    }
}