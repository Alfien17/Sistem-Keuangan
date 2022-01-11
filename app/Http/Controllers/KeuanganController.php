<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Keuangan;
use App\Models\Total;
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

        $keuangan = Keuangan::orderBy('updated_at','DESC')->get();
        $saldo = Keuangan::sum('total');
        return view('rekap.rekap', [
            'keuangan' => $keuangan,
            'saldo' => $saldo,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function addin()
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

        $kat = Kategori::get();
        $akun = Akun::get();
        $kas = Bukukas::get();
        return view('rekap.tpemasukan',[
            'kat' => $kat,
            'akun' => $akun,
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function postaddin(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'kd_akun' => 'required|exists:akun',
            'bk_kas' => 'required|exists:bukukas',
            'kat' => 'required',
            'debit' => 'required',
        ]);
   
        $status = "Debit";
        $kredit = "0";
        $total = $request->debit - $kredit;
        $akun_id = Akun::where('kd_akun',$request->kd_akun)->first();
        $kas_id = Bukukas::where('bk_kas',$request->bk_kas)->first();
        $kategori_id = Kategori::where('name', $request->kat)->first();

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

            keuangan::create([
                'status' => $status,
                'tanggal' => $request->tanggal,
                'ket' => $request->ket,
                'debit' => $request->debit,
                'kredit' => $kredit,
                'total' => $total,
                'image' => $imageName,
                'akun_id' => $akun_id->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id,
            ]);

            $data = Total::where('kd_akun', $request->kd_akun)->first();
            if (empty($data)) {
                Total::create([
                    'akun_id' => $akun_id->id,
                    'kd_akun' => $request->kd_akun,
                    'total' => $total
                ]);
                $data = Total::where('kd_akun', $request->kd_akun)->first();
                $data->update();
            } else {
                $data->total = $data->total + $total;
                $data->update();
            }

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function addout()
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

        $kat = Kategori::get();
        $akun = Akun::get();
        $kas = Bukukas::get();
        return view('rekap.tpengeluaran', [
            'kat' => $kat,
            'akun' => $akun,
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function postaddout(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'kd_akun' => 'required|exists:akun',
            'bk_kas' => 'required|exists:bukukas',
            'kat' => 'required',
            'kredit' => 'required|numeric',
        ]);

        $status = "Kredit";
        $debit = "0";
        $total = $debit - $request->kredit;
        $akun_id = Akun::where('kd_akun', $request->kd_akun)->first();
        $kas_id = Bukukas::where('bk_kas', $request->bk_kas)->first();
        $kategori_id = Kategori::where('name', $request->kat)->first();


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

        if($akun_id->check == 'true'){
            keuangan::create([
                'status' => $status,
                'tanggal' => $request->tanggal,
                'ket' => $request->ket,
                'kredit' => $request->kredit,
                'debit' => $debit,
                'total' => $total,
                'image' => $imageName,
                'akun_id' => $akun_id->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id,
            ]);

            $data = Total::where('kd_akun', $request->kd_akun)->first();
            if (empty($data)) {
                Total::create([
                    'akun_id' => $akun_id->id,
                    'kd_akun' => $request->kd_akun,
                    'total' => $total
                ]);
                $data = Total::where('kd_akun', $request->kd_akun)->first();
                $data->update();
            } else {
                $data->total = $data->total + $total;
                $data->update();
            }
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
        else {
            $saldo = Keuangan::where('akun_id',$akun_id->id)->sum('total');
            if ($request->kredit <= $saldo && !empty($saldo)) {
                keuangan::create([
                'status' => $status,
                'tanggal' => $request->tanggal,
                'ket' => $request->ket,
                'kredit' => $request->kredit,
                'debit' => $debit,
                'total' => $total,
                'image' => $imageName,
                'akun_id' => $akun_id->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id,
                ]);

                $data = Total::where('kd_akun', $request->kd_akun)->first();
                if (empty($data)) {
                    Total::create([
                        'akun_id' => $akun_id->id,
                        'kd_akun' => $request->kd_akun,
                        'total' => $total,
                    ]);
                    $data = Total::where('kd_akun', $request->kd_akun)->first();
                    $data->update();
                } else {
                    $data->total = $data->total + $total;
                    $data->update();
                }

                return redirect()->back()->with('success', 'Data berhasil ditambahkan');
            } else {
                $saldo = Keuangan::where('akun_id', $akun_id->id)->sum('total');  
                return redirect()->back()
                ->with('g_kredit', 'Proses ditolak karena saldo dari akun '. $request->kd_akun.' tidak cukup. Saldo = Rp. '.number_format((float)$saldo));
            }
        }
    }

    public function update($id)
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

        $kat = Kategori::get();
        $akun = Akun::get();
        $kas = Bukukas::get();
        $fakun = Akun::first();
        $fkas = Bukukas::first();
        $data = Keuangan::where('id', $id)->get();
        $kodee = Keuangan::where('id',$id)->first();
        $total = Keuangan::where('akun_id',$kodee->akun_id)->sum('total');     
        $saldo = Keuangan::sum('total');

        if ($kodee->status=="Debit") {
            return view('rekap.update1', [
                'kat' => $kat,
                'data' => $data,
                'total' => $total,
                'saldo' => $saldo,
                'akun' => $akun,
                'kas' => $kas,
                'fakun' => $fakun,
                'fkas' => $fkas,
                'forename' => $forename,
                'surname' => $surname,
                'year' => $year
            ]);
        } else {
            return view('rekap.update2', [
                'kat' => $kat,
                'data' => $data,
                'total' => $total,
                'saldo' => $saldo,
                'akun' => $akun,
                'kas' => $kas,
                'fakun' => $fakun,
                'fkas' => $fkas,
                'forename' => $forename,
                'surname' => $surname,
                'year' => $year
            ]);
        }
    }

    public function postupdatein(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'kd_akun' => 'required|exists:akun',
            'bk_kas' => 'required|exists:bukukas',
            'kat' => 'required',
            'debit' => 'required|numeric',

        ]);

        $kredit = "0";

        $akun_id = Akun::where('kd_akun', $request->kd_akun)->first();
        $kas_id = Bukukas::where('bk_kas', $request->bk_kas)->first();
        $kategori_id = Kategori::where('name', $request->kat)->first();
        $ids = Keuangan::where('id',$id)->first();
        $idtotal = Total::where('akun_id', $akun_id->id)->first();
        $sisa = Keuangan::where('akun_id',$ids->akun_id)->where('id','!=',$id)->sum('total');
        $hasil2 = $sisa + $request->debit;
        $total = $request->debit - $kredit;
        $selisih = $ids->total - $total;
        $kodeakun = Akun::where('id', $ids->akun_id)->first();
        $kodebaru = Total::where('kd_akun', $request->kd_akun)->first();

        if(empty($kodeakun)){
            if(empty($idtotal)){
                Total::create([
                    'akun_id' => $akun_id->id,
                    'kd_akun' => $request->kd_akun,
                    'total' => $total
                ]); 
            }else{
                $data = Total::where('kd_akun', $request->kd_akun)->first();
                $data->total = $data->total + $total;
                $data->update();
            }
        }else{
            if($request->kd_akun != $kodeakun->kd_akun){
                $kodelama = Total::where('kd_akun', $kodeakun->kd_akun)->first();
                $kodebaru = Total::where('kd_akun', $request->kd_akun)->first();
                if($sisa < 0){
                    if($kodeakun->check == 'true'){
                        $data = Total::where('kd_akun', $request->kd_akun)->first();
                        $data->total = $data->total + $total;                 
                        $data->update();

                        $kodelama = Total::where('kd_akun', $kodeakun->kd_akun)->first();
                        $data2 = Total::where('kd_akun', $kodeakun->kd_akun)->first();
                        $selisihlama = $kodelama->total - $total;
                        $data2->total = $selisihlama;
                        $data2->update();

                        Keuangan::where('id', $request->id)->update([
                            'tanggal' => $request->tanggal,
                            'ket' => $request->ket,
                            'debit' => $request->debit,
                            'total' => $request->debit,
                            'akun_id' => $akun_id->id,
                            'kas_id' => $kas_id->id,
                            'kategori_id' => $kategori_id->id
                        ]);
                        return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');
                    }
                    else{
                        return redirect()->back()->with('g_upin2', 'Akses ditolak karena akan membuat saldo pada akun '
                        . $kodeakun->kd_akun . ' di bawah nol.');
                    }
                }else{
                    $data2 = Total::where('kd_akun', $kodeakun->kd_akun)->first();
                    if(empty($data2)){
                        Total::create([
                            'akun_id' => $akun_id->id,
                            'kd_akun' => $request->kd_akun,
                            'total' => $total
                        ]);
                    }else{
                        $selisihlama = $kodelama->total - $total;
                        $data2->total = $selisihlama;
                        $data2->update();
                    }
                }

                if($hasil2 < 0){
                    return redirect()->back()->with('g_upin2', 'Akses ditolak karena akan membuat saldo pada akun '
                    . $kodeakun->kd_akun . ' di bawah nol.');
                }else{
                    if(empty($kodebaru->total)){
                        if(empty($kodebaru)){
                            Total::create([
                                'akun_id' => $akun_id->id,
                                'kd_akun' => $request->kd_akun,
                                'total' => $total
                            ]);
                        }else{
                            $totalkosong = "0";
                            $selisihbaru = $totalkosong + $total;
                            $data = Total::where('kd_akun', $request->kd_akun)->first();
                            $data->total = $selisihbaru;
                            $data->update();
                        }
                    }else{
                        $selisihbaru = $kodebaru->total + $total;
                        $data = Total::where('kd_akun', $request->kd_akun)->first();
                        $data->total = $selisihbaru;
                        $data->update();
                    }

                }

            }elseif ($request->kd_akun==$kodeakun->kd_akun) {
                if ($hasil2 < 0) {
                    return redirect()->back()->with('g_upin2', 'Akses ditolak karena akan membuat saldo pada akun '
                    . $kodeakun->kd_akun . ' di bawah nol.');
                } else {
                    $data = Total::where('kd_akun', $request->kd_akun)->first();
                    $data->total = $data->total - $selisih;
                    $data->update();
                }

            }else{
                return redirect()->back()->with('g_upin', 'Akses ditolak karena kode yang diubah ('
                .$request->kd_akun. ') belum melakukan tambah debit. Lakukan tambah debit dahulu!');
            }
        }

            Keuangan::where('id', $request->id)->update([
                'tanggal' => $request->tanggal,
                'ket' => $request->ket,
                'debit' => $request->debit,
                'total' => $request->debit,
                'akun_id' => $akun_id->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id
            ]);
            return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');

    }

    public function postupdateout(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'kd_akun' => 'required|exists:akun',
            'bk_kas' => 'required|exists:bukukas',
            'kat' => 'required',
            'kredit' => 'required|numeric',

        ]);

        $debit = "0";

        $akun_id = Akun::where('kd_akun', $request->kd_akun)->first();
        $kas_id = Bukukas::where('bk_kas', $request->bk_kas)->first();
        $kategori_id = Kategori::where('name', $request->kat)->first();
        $idtotal = Total::where('akun_id',$akun_id->id)->first();
        $ids = Keuangan::where('id', $id)->first();
        $kodeakun = Akun::where('id', $ids->akun_id)->first();
        $sisa = Keuangan::where('akun_id', $akun_id->id)->where('id', '!=', $id)->sum('total');
        $total = $debit - $request->kredit;
        $selisih = $ids->total - $total;

        if ($akun_id->check == 'true') {
            if (empty($idtotal)) {
                return redirect()->back()->with('g_upout2', 'Akses ditolak karena kode yang diubah ('
                . $request->kd_akun . ') belum melakukan tambah debit. Lakukan tambah debit dahulu!');
            } else {
                $data = Total::where('akun_id', $akun_id->id)->first();
                $data->total = $data->total - $selisih;
                $data->update();
                Keuangan::where('id', $request->id)->update([
                    'tanggal' => $request->tanggal,
                    'ket' => $request->ket,
                    'kredit' => $request->kredit,
                    'total' => $total,
                    'akun_id' => $akun_id->id,
                    'kas_id' => $kas_id->id,
                    'kategori_id' => $kategori_id->id
                ]);
                return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');
            }
        }


        if (empty($kodeakun)) {
            if(empty($idtotal)){
                return redirect()->back()->with('g_upout2', 'Akses ditolak karena kode yang diubah ('
                . $request->kd_akun . ') belum melakukan tambah debit. Lakukan tambah debit dahulu!');
            }else{
                $data = Total::where('akun_id', $akun_id->id)->first();
                if($data->total < $request->kredit){
                    return redirect()->back()->with('g_upout', 'Proses ditolak karena saldo dari akun '
                    . $request->kd_akun . ' tidak cukup. Batas melakukan kredit adalah Rp. ' . number_format((float)$sisa)); 
                }else{
                    $data->total = $data->total + $total;
                    $data->update();

                    Keuangan::where('id', $request->id)->update([
                        'tanggal' => $request->tanggal,
                        'ket' => $request->ket,
                        'kredit' => $request->kredit,
                        'total' => $total,
                        'akun_id' => $akun_id->id,
                        'kas_id' => $kas_id->id,
                        'kategori_id' => $kategori_id->id
                    ]);
                    return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');
                }
            }
        }
        else{
        $saldo = Keuangan::where('akun_id', $akun_id->id)->where("status","=","Debit")->sum('total');
        if($request->kredit <= $saldo && !empty($saldo)){
            $kodelama = Total::where('kd_akun', $kodeakun->kd_akun)->first();
            $kodebaru = Total::where('kd_akun', $request->kd_akun)->first();
            if ($request->kd_akun != $kodeakun->kd_akun) {
                $data2 = Total::where('kd_akun', $kodeakun->kd_akun)->first();
                $selisihlama = $kodelama->total - $total;
                $data2->total = $selisihlama;
                $data2->update(); 

                if (empty($kodebaru->total)) {
                    $totalkosong = "0";
                    $selisihbaru = $totalkosong + $total;
                    $data = Total::where('kd_akun', $request->kd_akun)->first();
                    $data->total = $selisihbaru;
                    $data->update();

                } else {
                    $selisihbaru = $kodebaru->total + $total;
                    $data = Total::where('kd_akun', $request->kd_akun)->first();
                    $data->total = $selisihbaru;
                    $data->update();
                }

            } elseif ($request->kd_akun == $kodeakun->kd_akun) {
                $data = Total::where('kd_akun', $request->kd_akun)->first();
                $data->total = $data->total - $selisih;
                $data->update(); 
                
            } else {
                return redirect()->back()->with('g_upout2', 'Akses ditolak karena kode yang diubah ('
                . $request->kd_akun . ') belum melakukan tambah debit. Lakukan tambah debit dahulu!');
            }

            Keuangan::where('id', $request->id)->update([
                'tanggal' => $request->tanggal,
                'ket' => $request->ket,
                'kredit' => $request->kredit,
                'total' => $total,
                'akun_id' => $akun_id->id,
                'kas_id' => $kas_id->id,
                'kategori_id' => $kategori_id->id
            ]);
            return redirect('/main/keuangan')->with('success', 'Data berhasil diubah');

        }else{
            return redirect()->back()->with('g_upout', 'Proses ditolak karena saldo dari akun '
            . $request->kd_akun . ' tidak cukup. Batas melakukan kredit adalah Rp. ' . number_format((float)$sisa));
        }
        }
    }

    public function drekap($id)
    {
        $ids = Keuangan::where('id', $id)->first();
        $akun = Akun::where('id', $ids->akun_id)->first();
        $saldo_d = Total::where('akun_id', $ids->akun_id)->first();
        if (empty($saldo_d)) {
            Keuangan::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }
        else{
            if($ids->status == "Debit"){
                $saldo_d->total = $saldo_d->total - $ids->debit;
                if ($saldo_d->total < 0) {
                    return redirect()->back()
                    ->with('g_delete', 'Akses ditolak karena akan membuat saldo pada akun '
                    . $akun->kd_akun . ' di bawah nol.');
                } else {
                    $saldo_d->update();
                    Keuangan::where('id', $id)->delete();
                    return redirect()->back()->with('success', 'Data berhasil dihapus');
                }
            }elseif($ids->status == "Kredit"){
                $saldo_d->total = $saldo_d->total + $ids->kredit;
                if ($saldo_d->total < 0) {
                    return redirect()->back()
                        ->with('g_delete', 'Akses ditolak karena akan membuat saldo pada akun '
                        . $akun->kd_akun . ' di bawah nol.');
                } else {
                    $saldo_d->update();
                    Keuangan::where('id', $id)->delete();
                    return redirect()->back()->with('success', 'Data berhasil dihapus');
                }
            }
        }
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

        $data = Keuangan::where('id', $id)->get();
        $kode = Keuangan::where('id', $id)->first();
        $total = Keuangan::where('akun_id', $kode->akun_id)->sum('total');  
        $saldo = Keuangan::sum('total');

        return view('rekap.detail', [
            'data' => $data,
            'total' => $total,
            'saldo' => $saldo,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    // CRUD Image
    public function eimage(Request $request, $id)
    {
        $image = Keuangan::where('id', $id)->first();
        if($image->image != 'default/default.png'){
            if ($request->hasfile('image')) {
                File::delete(public_path() . '/assets/' . $image->image);
                $image = $request->file('image');
                $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
                $imgLoc = 'assets/image';
                $image->move($imgLoc, $imageName);
                Keuangan::where('id', $id)->update(['image' => $imageName]);
                return redirect()->back()->with('s_eimg', 'Gambar berhasil diubah');
            }else{
                return redirect()->back()->with('g_img', 'Gambar tidak dapat ditemukan');
            }
        }else{
            if ($request->hasfile('image')) {
                $image = $request->file('image');
                $imageName = "image/" . time() . "_" . $image->getClientOriginalName();
                $imgLoc = 'assets/image';
                $image->move($imgLoc, $imageName);
                Keuangan::where('id', $id)->update(['image' => $imageName]);
                return redirect()->back()->with('s_eimg', 'Gambar berhasil diubah');
            } else {
                return redirect()->back()->with('g_img', 'Gambar tidak dapat ditemukan');
            }
        }
    }

    public function dimage($id)
    {
        $image = Keuangan::where('id',$id)->first();
        if ($image->image != 'default/default.png') {
            File::delete(public_path() . '/assets/' . $image->image);
            Keuangan::where('id', $id)->update([
                'image' => 'default/default.png'
            ]);
            return redirect()->back()->with('s_dimg', 'Gambar berhasil dihapus');
        } else {
            return redirect()->back()->with('g_img', 'Gambar tidak dapat ditemukan');
        }
    }

    public function multi()
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

        $kat = Kategori::get();
        $akun = Akun::get();
        $kas = Bukukas::get();
        return view('rekap.multiform', [
            'kat' => $kat,
            'akun' => $akun,
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }
}
