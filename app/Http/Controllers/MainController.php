<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Akun;
use App\Models\Total;
use App\Models\Bukukas;
use App\Models\Kategori;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 

class MainController extends Controller
{
    public function main()
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

        return view('main',[
            'forename' => $forename,
            'surname' => $surname
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

        $akun = Akun::count();
        $kas = Bukukas::count();
        $kat = Kategori::count();
        $debit = Keuangan::where('status','debit')->sum('debit');
        $kredit = Keuangan::where('status', 'kredit')->sum('kredit');
        $saldo = $debit - $kredit;
        $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $kode = Total::get();
        $year = Carbon::now()->format('Y');
        $sort = Keuangan::select(DB::raw('YEAR(tanggal) year'))->groupBy('year')->get();

        $jan = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '01')->sum('total');
        $feb = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '02')->sum('total');
        $mar = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '03')->sum('total');
        $apr = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '04')->sum('total');
        $mei = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '05')->sum('total');
        $jun = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '06')->sum('total');
        $jul = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '07')->sum('total');
        $ags = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '08')->sum('total');
        $sep = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '09')->sum('total');
        $okt = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '10')->sum('total');
        $nov = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '11')->sum('total');
        $des = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '12')->sum('total');
        return view('dashboard.dashboard', [
            'kas' => $kas,
            'kat' => $kat,
            'akun' => $akun,
            'today' => $today,
            'debit' => $debit,
            'kredit' => $kredit,
            'saldo' => $saldo,
            'kode' => $kode,
            'sort' => $sort,
            'year' => $year,
            'jan' => $jan,
            'feb' => $feb,
            'mar' => $mar,
            'apr' => $apr,
            'mei' => $mei,
            'jun' => $jun,
            'jul' => $jul,
            'ags' => $ags,
            'sep' => $sep,
            'okt' => $okt,
            'nov' => $nov,
            'des' => $des,
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    public function sortyear(Request $request)
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

        $akun = Akun::count();
        $kas = Bukukas::count();
        $kat = Kategori::count();
        $debit = Keuangan::where('status', 'debit')->sum('debit');
        $kredit = Keuangan::where('status', 'kredit')->sum('kredit');
        $saldo = $debit - $kredit;
        $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $kode = Total::get();
        if(!empty($request->sortir)){
            $year = $request->get('sortir');
        }else{
            $year = Carbon::now()->format('Y');
        }
        $sort = Keuangan::select(DB::raw('YEAR(tanggal) year'))->groupBy('year')->get();

        $jan = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '01')->sum('total');
        $feb = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '02')->sum('total');
        $mar = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '03')->sum('total');
        $apr = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '04')->sum('total');
        $mei = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '05')->sum('total');
        $jun = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '06')->sum('total');
        $jul = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '07')->sum('total');
        $ags = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '08')->sum('total');
        $sep = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '09')->sum('total');
        $okt = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '10')->sum('total');
        $nov = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '11')->sum('total');
        $des = Keuangan::whereYear('tanggal', $year)->whereMonth('tanggal', '12')->sum('total');
        return view('dashboard.dashboard', [
            'kas' => $kas,
            'kat' => $kat,
            'akun' => $akun,
            'today' => $today,
            'debit' => $debit,
            'kredit' => $kredit,
            'saldo' => $saldo,
            'kode' => $kode,
            'sort' => $sort,
            'year' => $year,
            'jan' => $jan,
            'feb' => $feb,
            'mar' => $mar,
            'apr' => $apr,
            'mei' => $mei,
            'jun' => $jun,
            'jul' => $jul,
            'ags' => $ags,
            'sep' => $sep,
            'okt' => $okt,
            'nov' => $nov,
            'des' => $des,
            'surname' => $surname,
            'forename' => $forename
        ]);
    }

    // CRUD AKUN
    public function tambahakun()
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
        return view('akun.tambahakun', [
            'akun' => $akun,
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    public function addakun(Request $request){
    	$this->validate($request,[
            'nama_akun' => 'required|unique:akun',
            'kd_akun' => 'required|unique:akun'      
        ]);
    	Akun::create([
            'nama_akun' => $request->nama_akun,
            'kd_akun' => $request->kd_akun
        ]);
	    return redirect('/main/akun')->with('success','Akun berhasil ditambahkan.');
	}

    public function eakun(Request $request)
    {
        $this->validate($request, [
            'nama_akun' => 'required|unique:akun',
            'kd_akun' => 'required|unique:akun'
        ]);
        Akun::where('id', $request->id,)->update([
            'nama_akun' => $request->nama_akun,
            'kd_akun' => $request->kd_akun
        ]);
        return redirect('/main/akun')->with('success', 'Akun berhasil diubah');
    }

    // public function deleteakun(Request $request)
    // {
    //     $ids = $request->ids;
    //     Akun::whereIn('id', explode(",", $ids))->delete();
    //     return response()->json(['success'=>"Data berhasil dihapus."]);
    // }

    public function dakun($id)
    {
        Total::where('akun_id',$id)->delete();
        DB::table("akun")->delete($id);
        return redirect('/main/akun')->with('success', 'Akun berhasil dihapus.');
    }

    // CRUD BUKU KAS
    public function tambahkas()
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

        $kas = Bukukas::get();
        return view('kas.tambahkas', [
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    public function addkas(Request $request)
    {
        $this->validate($request, [
            'bk_kas' => 'required|unique:bukukas',
            'tipe' => 'required'
        ]);
        Bukukas::create([
            'bk_kas' => $request->bk_kas,
            'tipe' => $request->tipe
        ]);
        return redirect('/main/kas')->with('success', 'Kas berhasil ditambahkan');
    }

    public function ekas(Request $request)
    {
        $this->validate($request, [
            'bk_kas' => 'required',
            'tipe' => 'required'
        ]);
        Bukukas::where('id', $request->id,)->update([
            'bk_kas' => $request->bk_kas,
            'tipe' => $request->tipe
        ]);
        return redirect('/main/kas')->with('success', 'Kas berhasil diubah.');
    }

    // public function deletekas(Request $request)
    // {
    //     $ids = $request->ids;
    //     Bukukas::whereIn('id', explode(",", $ids))->delete();
    //     return response()->json(['success' => "Data berhasil dihapus."]);
    // }

    public function dkas($id)
    {
        Bukukas::where('id', $id)->delete();
        return redirect('/main/kas')->with('success', 'Kas berhasil dihapus.');;
    }

    // CRUD Kategori
    public function tambahkat()
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

        $kat = Kategori::get();
        return view('kategori.tambahkat', [
            'kat' => $kat,
            'surname' => $surname,
            'forename' => $forename
        ]);
    }

    public function addkat(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:kategori',]);
        kategori::create(['name' => $request->name]);
        return redirect('/main/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function ekat(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:kategori',]);
        Kategori::where('id', $request->id,)->update(['name' => $request->name]);
        return redirect('/main/kategori')->with('success', 'Kategori berhasil diubah');
    }

    // public function deletekat(Request $request)
    // {
    //     $ids = $request->ids;
    //     Kategori::whereIn('id', explode(",", $ids))->delete();
    //     return response()->json(['success' => "Data berhasil dihapus"]);
    // }

    public function dkat($id)
    {
        Kategori::where('id', $id)->delete();
        return redirect('/main/kategori')->with('success', 'Kategori berhasil dihapus');
    }

    // Search
    public function searchakun(Request $request)
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

        $search = $request->get('search');
        $akun = Akun::where('nama_akun', 'like', '%' . $search . '%')->get();
        return view('akun.tambahakun', [
            'akun' => $akun,
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    public function searchkas(Request $request)
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

        $search = $request->get('search');
        $kas = Bukukas::where('bk_kas', 'like', '%' . $search . '%')->get();
        return view('kas.tambahkas', [
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    public function searchkat(Request $request)
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

        $search = $request->get('search');
        $kat = Kategori::where('name', 'like', '%' . $search . '%')->get();
        return view('kategori.tambahkat', [
            'kat' => $kat,
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    // Reset Data
    public function reset()
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

        return view('reset.resetview',[
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    public function delakun()
    {
        if (Akun::exists()) {
            Akun::truncate();
            Total::truncate();
            return redirect()->back()->with('success', 'Reset data akun berhasil');
        } else {
            return redirect()->back()->with('warning', 'Proses ditolak karena data kosong');
        }
    }

    public function delkas()
    {
        if (Bukukas::exists()) {
            Bukukas::truncate();
            return redirect()->back()->with('success', 'Reset data buku kas berhasil');
        } else {
            return redirect()->back()->with('warning', 'Proses ditolak karena data kosong');
        }
    }

    public function delkat()
    {
        if (Kategori::exists()) {
            Kategori::truncate();
            return redirect()->back()->with('success', 'Reset data kategori berhasil');
        } else {
            return redirect()->back()->with('warning', 'Proses ditolak karena data kosong');
        }
    }

    public function delkeu()
    {
        if (Keuangan::exists()) {
            Keuangan::truncate();
            Total::truncate();
            File::deleteDirectory(public_path('/assets/image'));
            return redirect()->back()->with('success', 'Reset data keuangan berhasil');
        } else {
            return redirect()->back()->with('warning', 'Proses ditolak karena data kosong');
        }
    }

    public function help()
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

        return view('help.helpview', [
            'forename' => $forename,
            'surname' => $surname
        ]);
    }
}