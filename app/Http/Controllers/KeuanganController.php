<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\DataKeuangan;
use App\Models\Akun;
use App\Models\Bukukas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class KeuanganController extends Controller
{
    public function rekap()
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

        $keuangan = DataKeuangan::orderBy('updated_at', 'DESC')->get();
        return view('rekap.rekap2', [
            'keuangan' => $keuangan,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year,
        ]);
    }

    public function addkeu()
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

        $kat = Kategori::orderBy('name', 'ASC')->get();
        $akun = Akun::orderBy('kd_akun', 'ASC')->get();
        $kas = Bukukas::orderBy('bk_kas', 'ASC')->get();
        return view('rekap.addkeu', [
            'kat' => $kat,
            'akun' => $akun,
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function postaddkeu(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'kat' => 'required',
            'uang' => 'required',
        ]);

        $kas_id = Bukukas::where('bk_kas', $request->bk_kas)->first();
        $kategori_id = Kategori::where('name', $request->kat)->first();
        $akun_id1 = Akun::where('kd_akun', $request->kd_akun1)->first();
        $akun_id2 = Akun::where('kd_akun', $request->kd_akun2)->first();

        $debit = 0;
        $kredit = 0;
        $total_d = $request->uang-$kredit;
        $total_k = $debit-$request->uang;

        $number = DataKeuangan::orderBy('id', 'desc')->first();
        if ($number === null) {
            $kode = 'TRN001';
        } else {
            $kode = new DataKeuangan();
            $kode = 'TRN00' . ($number->id + 1);
        }

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
            $path = public_path('assets/image');
            File::makeDirectory($path, 0777, true, true);
            $imgLoc = 'assets/image';
            $image->move($imgLoc, $imageName);
        } else {
            $imageName = 'default/default.png';
        }

        if(empty($kas_id) && !empty($akun_id1) && !empty($akun_id2)) {
            return redirect()->back()->with('g_bkkas1', 'The selected Buku Kas is invalid.');
        }
        elseif (!empty($kas_id) && empty($akun_id1) && !empty($akun_id2)) {
            return redirect()->back()->with('g_kdakun1', 'The selected Kode Akun is invalid.');
        }
        elseif (!empty($kas_id) && !empty($akun_id1) && empty($akun_id2)) {
            return redirect()->back()->with('g_kdakun2', 'The selected Kode Akun is invalid.');
        }
        elseif (!empty($kas_id) && empty($akun_id1) && empty($akun_id2)) {
            return redirect()->back()->with('g_kdakun3', 'The selected Kode Akun is invalid.');
        }
        elseif (empty($kas_id) && empty($akun_id1) && empty($akun_id2)){
            return redirect()->back()
                ->with('g_bkkas2', 'The selected Buku Kas is invalid.')
                ->with('g_kdakun3', 'The selected Kode Akun is invalid.');
        }

        if($akun_id1->id == $akun_id2->id){
            return redirect()->back()->with('g_addkeu', 'Kode Akun Debit dan Kredit tidak boleh sama');
        }
        else{
            // Data Debit
            DataKeuangan::create([
                'kode' => $kode,
                'tanggal' => $request->tanggal,
                'status' => 'debit',
                'akun_id' => $akun_id1->id,
                'hubungan' => $akun_id2->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id,
                'ket1' => $request->ket1,
                'debit' => $request->uang,
                'kredit' => $kredit,
                'total' => $total_d,
                'image' => $imageName,
            ]);
            // Data Kredit
            DataKeuangan::create([
                'kode' => $kode,
                'tanggal' => $request->tanggal,
                'status' => 'kredit',
                'akun_id' => $akun_id2->id,
                'hubungan' => $akun_id1->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id,
                'ket2' => $request->ket2,
                'debit' => $debit,
                'kredit' => $request->uang,
                'total' => $total_k,
                'image' => $imageName,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function editkeu($id)
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

        $kat = Kategori::orderBy('name', 'ASC')->get();
        $akun = Akun::orderBy('kd_akun', 'ASC')->get();
        $kas = Bukukas::orderBy('bk_kas', 'ASC')->get();
        $data = DataKeuangan::where('id', $id)->get();
        $data2 = DataKeuangan::get();
        return view('rekap.editkeu', [
            'kat' => $kat,
            'data' => $data,
            'data2' => $data2,
            'akun' => $akun,
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function postupdatekeu(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'kat' => 'required',
            'uang' => 'required',
        ]);

        $kas_id = Bukukas::where('bk_kas', $request->bk_kas)->first();
        $kategori_id = Kategori::where('name', $request->kat)->first();
        $akun_id1 = Akun::where('kd_akun', $request->kd_akun1)->first();
        $akun_id2 = Akun::where('kd_akun', $request->kd_akun2)->first();
        $ids = DataKeuangan::where('id', $id)->first();

        $debit = 0;
        $kredit = 0;
        $total_d = $request->uang - $kredit;
        $total_k = $debit - $request->uang;

        if ($request->has('check')) {
            File::delete(public_path() . '/assets/' . $ids->image);
            $imageName = 'default/default.png';
        } 
        else {
            if ($ids->image != 'default/default.png' && $request->hasfile('image')) {
                File::delete(public_path() . '/assets/' . $ids->image);
                $image = $request->file('image');
                $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
                $imgLoc = 'assets/image';
                $image->move($imgLoc, $imageName);
            } 
            elseif ($ids->image == 'default/default.png' && $request->hasfile('image')) {
                $image = $request->file('image');
                $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
                $imgLoc = 'assets/image';
                $image->move($imgLoc, $imageName);
            } 
            else {
                $imageName = $ids->image;
            }
        }

        if (empty($kas_id) && !empty($akun_id1) && !empty($akun_id2)) {
            return redirect()->back()->with('g_bkkas1', 'The selected Buku Kas is invalid.');
        } 
        elseif (!empty($kas_id) && empty($akun_id1) && !empty($akun_id2)) {
            return redirect()->back()->with('g_kdakun1', 'The selected Kode Akun is invalid.');
        } 
        elseif (!empty($kas_id) && !empty($akun_id1) && empty($akun_id2)) {
            return redirect()->back()->with('g_kdakun2', 'The selected Kode Akun is invalid.');
        } 
        elseif (!empty($kas_id) && empty($akun_id1) && empty($akun_id2)) {
            return redirect()->back()->with('g_kdakun3', 'The selected Kode Akun is invalid.');
        } 
        elseif (empty($kas_id) && empty($akun_id1) && empty($akun_id2)) {
            return redirect()->back()
                ->with('g_bkkas2', 'The selected Buku Kas is invalid.')
                ->with('g_kdakun3', 'The selected Kode Akun is invalid.');
        }

        if ($akun_id1->id == $akun_id2->id) {
            return redirect()->back()->with('g_editkeu', 'Kode Akun Debit dan Kredit tidak boleh sama');
        } else {
            // Data Debit
            DataKeuangan::where('id', $request->id)->update([
                'tanggal' => $request->tanggal,
                'akun_id' => $akun_id1->id,
                'hubungan' => $akun_id2->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id,
                'ket1' => $request->ket1,
                'debit' => $request->uang,
                'total' => $total_d,
                'image' => $imageName,
            ]);
            // Data Kredit
            DataKeuangan::where('kode', $ids->kode)->where('status', 'kredit')->update([
                'tanggal' => $request->tanggal,
                'akun_id' => $akun_id2->id,
                'hubungan' => $akun_id1->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id,
                'ket2' => $request->ket2,
                'kredit' => $request->uang,
                'total' => $total_k,
                'image' => $imageName,
            ]);

            return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');
        }
    }

    public function drekap($id)
    {
        $ids = DataKeuangan::where('id',$id)->first();
        DataKeuangan::where('kode', $ids->kode)->where('status', 'kredit')->delete();
        DataKeuangan::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function detail($id)
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

        $data = DataKeuangan::where('id', $id)->get();
        $data2 = DataKeuangan::get();
        return view('rekap.detail', [
            'data' => $data,
            'data2' => $data2,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    // Reset Keuangan
    public function delkeu()
    {
        if (DataKeuangan::exists()) {
            DataKeuangan::query()->delete();
            File::deleteDirectory(public_path('/assets/image'));
            return redirect()->back()->with('success', 'Reset data keuangan berhasil');
        } else {
            return redirect()->back()->with('warning', 'Proses ditolak karena data kosong');
        }
    } 

    // public function addin()
    // {
    //     // Check Login
    //     if (!Auth::user()) {
    //         return redirect('/login');
    //     }

    //     $year = Carbon::now()->format('Y');
    //     $auth = Auth::user();
    //     $nama = $auth->name;
    //     $pecah = explode(' ', $nama);
    //     $forename = $pecah[0];
    //     if (empty($pecah[1])) {
    //         $surname = "";
    //     } else {
    //         $surname = $pecah[1];
    //     }

    //     $kat = Kategori::get();
    //     $akun = Akun::get();
    //     $kas = Bukukas::get();
    //     return view('rekap.tpemasukan',[
    //         'kat' => $kat,
    //         'akun' => $akun,
    //         'kas' => $kas,
    //         'forename' => $forename,
    //         'surname' => $surname,
    //         'year' => $year
    //     ]);
    // }

    // public function postaddin(Request $request)
    // {
    //     $this->validate($request, [
    //         'tanggal' => 'required',
    //         'kd_akun' => 'required|exists:akun',
    //         'bk_kas' => 'required|exists:bukukas',
    //         'kat' => 'required',
    //         'debit' => 'required',
    //     ]);
   
    //     $status = "Debit";
    //     $kredit = "0";
    //     $total = $request->debit - $kredit;
    //     $akun_id = Akun::where('kd_akun',$request->kd_akun)->first();
    //     $kas_id = Bukukas::where('bk_kas',$request->bk_kas)->first();
    //     $kategori_id = Kategori::where('name', $request->kat)->first();

    //     if ($request->hasfile('image')) {
    //         $image = $request->file('image');
    //         $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
    //         $path = public_path('assets/image');
    //         File::makeDirectory($path, 0777, true, true);
    //         $imgLoc = 'assets/image';
    //         $image->move($imgLoc, $imageName);
    //     } else {
    //         $imageName = 'default/default.png';
    //     }

    //         keuangan::create([
    //             'status' => $status,
    //             'tanggal' => $request->tanggal,
    //             'ket' => $request->ket,
    //             'debit' => $request->debit,
    //             'kredit' => $kredit,
    //             'total' => $total,
    //             'image' => $imageName,
    //             'akun_id' => $akun_id->id,
    //             'kas_id' => $kas_id->id,
    //             'kategori_id' => $kategori_id->id,
    //         ]);

    //         $data = Total::where('kd_akun', $request->kd_akun)->first();
    //         if (empty($data)) {
    //             Total::create([
    //                 'akun_id' => $akun_id->id,
    //                 'kd_akun' => $request->kd_akun,
    //                 'total' => $total
    //             ]);
    //             $data = Total::where('kd_akun', $request->kd_akun)->first();
    //             $data->update();
    //         } else {
    //             $data->total = $data->total + $total;
    //             $data->update();
    //         }

    //         return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    // }

    // public function addout()
    // {
    //     // Check Login
    //     if (!Auth::user()) {
    //         return redirect('/login');
    //     }

    //     $year = Carbon::now()->format('Y');
    //     $auth = Auth::user();
    //     $nama = $auth->name;
    //     $pecah = explode(' ', $nama);
    //     $forename = $pecah[0];
    //     if (empty($pecah[1])) {
    //         $surname = "";
    //     } else {
    //         $surname = $pecah[1];
    //     }

    //     $kat = Kategori::get();
    //     $akun = Akun::get();
    //     $kas = Bukukas::get();
    //     return view('rekap.tpengeluaran', [
    //         'kat' => $kat,
    //         'akun' => $akun,
    //         'kas' => $kas,
    //         'forename' => $forename,
    //         'surname' => $surname,
    //         'year' => $year
    //     ]);
    // }

    // public function postaddout(Request $request)
    // {
    //     $this->validate($request, [
    //         'tanggal' => 'required',
    //         'kd_akun' => 'required|exists:akun',
    //         'bk_kas' => 'required|exists:bukukas',
    //         'kat' => 'required',
    //         'kredit' => 'required|numeric',
    //     ]);

    //     $status = "Kredit";
    //     $debit = "0";
    //     $total = $debit - $request->kredit;
    //     $akun_id = Akun::where('kd_akun', $request->kd_akun)->first();
    //     $kas_id = Bukukas::where('bk_kas', $request->bk_kas)->first();
    //     $kategori_id = Kategori::where('name', $request->kat)->first();


    //     if ($request->hasfile('image')) {
    //         $image = $request->file('image');
    //         $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
    //         $path = public_path('assets/image');
    //         File::makeDirectory($path, 0777, true, true);
    //         $imgLoc = 'assets/image';
    //         $image->move($imgLoc, $imageName);
    //     } else {
    //         $imageName = 'default/default.png';
    //     }

    //     if($akun_id->check == 'true'){
    //         keuangan::create([
    //             'status' => $status,
    //             'tanggal' => $request->tanggal,
    //             'ket' => $request->ket,
    //             'kredit' => $request->kredit,
    //             'debit' => $debit,
    //             'total' => $total,
    //             'image' => $imageName,
    //             'akun_id' => $akun_id->id,
    //             'kas_id' => $kas_id->id,
    //             'kategori_id' => $kategori_id->id,
    //         ]);

    //         $data = Total::where('kd_akun', $request->kd_akun)->first();
    //         if (empty($data)) {
    //             Total::create([
    //                 'akun_id' => $akun_id->id,
    //                 'kd_akun' => $request->kd_akun,
    //                 'total' => $total
    //             ]);
    //             $data = Total::where('kd_akun', $request->kd_akun)->first();
    //             $data->update();
    //         } else {
    //             $data->total = $data->total + $total;
    //             $data->update();
    //         }
    //         return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    //     }
    //     else {
    //         $saldo = Keuangan::where('akun_id',$akun_id->id)->sum('total');
    //         if ($request->kredit <= $saldo && !empty($saldo)) {
    //             keuangan::create([
    //             'status' => $status,
    //             'tanggal' => $request->tanggal,
    //             'ket' => $request->ket,
    //             'kredit' => $request->kredit,
    //             'debit' => $debit,
    //             'total' => $total,
    //             'image' => $imageName,
    //             'akun_id' => $akun_id->id,
    //             'kas_id' => $kas_id->id,
    //             'kategori_id' => $kategori_id->id,
    //             ]);

    //             $data = Total::where('kd_akun', $request->kd_akun)->first();
    //             if (empty($data)) {
    //                 Total::create([
    //                     'akun_id' => $akun_id->id,
    //                     'kd_akun' => $request->kd_akun,
    //                     'total' => $total,
    //                 ]);
    //                 $data = Total::where('kd_akun', $request->kd_akun)->first();
    //                 $data->update();
    //             } else {
    //                 $data->total = $data->total + $total;
    //                 $data->update();
    //             }

    //             return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    //         } else {
    //             $saldo = Keuangan::where('akun_id', $akun_id->id)->sum('total');  
    //             return redirect()->back()
    //             ->with('g_kredit', 'Proses ditolak karena saldo dari akun '. $request->kd_akun.' tidak cukup. Saldo = Rp. '.number_format((float)$saldo));
    //         }
    //     }
    // }

    // public function postupdateout(Request $request, $id)
    // {
    //     $this->validate($request, [
    //         'tanggal' => 'required',
    //         'kd_akun' => 'required|exists:akun',
    //         'bk_kas' => 'required|exists:bukukas',
    //         'kat' => 'required',
    //         'kredit' => 'required|numeric',

    //     ]);

    //     $debit = "0";

    //     $akun_id = Akun::where('kd_akun', $request->kd_akun)->first();
    //     $kas_id = Bukukas::where('bk_kas', $request->bk_kas)->first();
    //     $kategori_id = Kategori::where('name', $request->kat)->first();
    //     $idtotal = Total::where('akun_id',$akun_id->id)->first();
    //     $ids = Keuangan::where('id', $id)->first();
    //     $kodeakun = Akun::where('id', $ids->akun_id)->first();
    //     $sisa = Keuangan::where('akun_id', $akun_id->id)->where('id', '!=', $id)->sum('total');
    //     $total = $debit - $request->kredit;
    //     $selisih = $ids->total - $total;

    //     if ($akun_id->check == 'true') {
    //         if (empty($idtotal)) {
    //             return redirect()->back()->with('g_upout2', 'Akses ditolak karena kode yang diubah ('
    //             . $request->kd_akun . ') belum melakukan tambah debit. Lakukan tambah debit dahulu!');
    //         } else {
    //             $data = Total::where('akun_id', $akun_id->id)->first();
    //             $data->total = $data->total - $selisih;
    //             $data->update();
    //             Keuangan::where('id', $request->id)->update([
    //                 'tanggal' => $request->tanggal,
    //                 'ket' => $request->ket,
    //                 'kredit' => $request->kredit,
    //                 'total' => $total,
    //                 'akun_id' => $akun_id->id,
    //                 'kas_id' => $kas_id->id,
    //                 'kategori_id' => $kategori_id->id
    //             ]);
    //             return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');
    //         }
    //     }


    //     if (empty($kodeakun)) {
    //         if(empty($idtotal)){
    //             return redirect()->back()->with('g_upout2', 'Akses ditolak karena kode yang diubah ('
    //             . $request->kd_akun . ') belum melakukan tambah debit. Lakukan tambah debit dahulu!');
    //         }else{
    //             $data = Total::where('akun_id', $akun_id->id)->first();
    //             if($data->total < $request->kredit){
    //                 return redirect()->back()->with('g_upout', 'Proses ditolak karena saldo dari akun '
    //                 . $request->kd_akun . ' tidak cukup. Batas melakukan kredit adalah Rp. ' . number_format((float)$sisa)); 
    //             }else{
    //                 $data->total = $data->total + $total;
    //                 $data->update();

    //                 Keuangan::where('id', $request->id)->update([
    //                     'tanggal' => $request->tanggal,
    //                     'ket' => $request->ket,
    //                     'kredit' => $request->kredit,
    //                     'total' => $total,
    //                     'akun_id' => $akun_id->id,
    //                     'kas_id' => $kas_id->id,
    //                     'kategori_id' => $kategori_id->id
    //                 ]);
    //                 return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');
    //             }
    //         }
    //     }
    //     else{
    //     $saldo = Keuangan::where('akun_id', $akun_id->id)->where("status","=","Debit")->sum('total');
    //     if($request->kredit <= $saldo && !empty($saldo)){
    //         $kodelama = Total::where('kd_akun', $kodeakun->kd_akun)->first();
    //         $kodebaru = Total::where('kd_akun', $request->kd_akun)->first();
    //         if ($request->kd_akun != $kodeakun->kd_akun) {
    //             $data2 = Total::where('kd_akun', $kodeakun->kd_akun)->first();
    //             $selisihlama = $kodelama->total - $total;
    //             $data2->total = $selisihlama;
    //             $data2->update(); 

    //             if (empty($kodebaru->total)) {
    //                 $totalkosong = "0";
    //                 $selisihbaru = $totalkosong + $total;
    //                 $data = Total::where('kd_akun', $request->kd_akun)->first();
    //                 $data->total = $selisihbaru;
    //                 $data->update();

    //             } else {
    //                 $selisihbaru = $kodebaru->total + $total;
    //                 $data = Total::where('kd_akun', $request->kd_akun)->first();
    //                 $data->total = $selisihbaru;
    //                 $data->update();
    //             }

    //         } elseif ($request->kd_akun == $kodeakun->kd_akun) {
    //             $data = Total::where('kd_akun', $request->kd_akun)->first();
    //             $data->total = $data->total - $selisih;
    //             $data->update(); 
                
    //         } else {
    //             return redirect()->back()->with('g_upout2', 'Akses ditolak karena kode yang diubah ('
    //             . $request->kd_akun . ') belum melakukan tambah debit. Lakukan tambah debit dahulu!');
    //         }

    //         Keuangan::where('id', $request->id)->update([
    //             'tanggal' => $request->tanggal,
    //             'ket' => $request->ket,
    //             'kredit' => $request->kredit,
    //             'total' => $total,
    //             'akun_id' => $akun_id->id,
    //             'kas_id' => $kas_id->id,
    //             'kategori_id' => $kategori_id->id
    //         ]);
    //         return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');

    //     }else{
    //         return redirect()->back()->with('g_upout', 'Proses ditolak karena saldo dari akun '
    //         . $request->kd_akun . ' tidak cukup. Batas melakukan kredit adalah Rp. ' . number_format((float)$sisa));
    //     }
    //     }
    // }

    // CRUD Image
    // public function eimage(Request $request, $id)
    // {
    //     $image = Keuangan::where('id', $id)->first();
    //     if($image->image != 'default/default.png'){
    //         if ($request->hasfile('image')) {
    //             File::delete(public_path() . '/assets/' . $image->image);
    //             $image = $request->file('image');
    //             $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
    //             $imgLoc = 'assets/image';
    //             $image->move($imgLoc, $imageName);
    //             Keuangan::where('id', $id)->update(['image' => $imageName]);
    //             return redirect()->back()->with('s_eimg', 'Gambar berhasil diubah');
    //         }else{
    //             return redirect()->back()->with('g_img', 'Gambar tidak dapat ditemukan');
    //         }
    //     }else{
    //         if ($request->hasfile('image')) {
    //             $image = $request->file('image');
    //             $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
    //             $imgLoc = 'assets/image';
    //             $image->move($imgLoc, $imageName);
    //             Keuangan::where('id', $id)->update(['image' => $imageName]);
    //             return redirect()->back()->with('s_eimg', 'Gambar berhasil diubah');
    //         } else {
    //             return redirect()->back()->with('g_img', 'Gambar tidak dapat ditemukan');
    //         }
    //     }
    // }

    // public function dimage($id)
    // {
    //     $image = Keuangan::where('id',$id)->first();
    //     if ($image->image != 'default/default.png') {
    //         File::delete(public_path() . '/assets/' . $image->image);
    //         Keuangan::where('id', $id)->update([
    //             'image' => 'default/default.png'
    //         ]);
    //         return redirect()->back()->with('s_dimg', 'Gambar berhasil dihapus');
    //     } else {
    //         return redirect()->back()->with('g_img', 'Gambar tidak dapat ditemukan');
    //     }
    // }

    // public function multi()
    // {
    //     // Check Login
    //     if (!Auth::user()) {
    //         return redirect('/login');
    //     }

    //     $year = Carbon::now()->format('Y');
    //     $auth = Auth::user();
    //     $nama = $auth->name;
    //     $pecah = explode(' ', $nama);
    //     $forename = $pecah[0];
    //     if (empty($pecah[1])) {
    //         $surname = "";
    //     } else {
    //         $surname = $pecah[1];
    //     }

    //     $kat = Kategori::get();
    //     $akun = Akun::get();
    //     $kas = Bukukas::get();
    //     return view('rekap.multiform', [
    //         'kat' => $kat,
    //         'akun' => $akun,
    //         'kas' => $kas,
    //         'forename' => $forename,
    //         'surname' => $surname,
    //         'year' => $year
    //     ]);
    // }
}
