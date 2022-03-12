<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Bukukas;
use Illuminate\Support\Facades\File; 

class BukuKasController extends Controller
{
    public function tambahkas()
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

        $kas = Bukukas::orderBy('bk_kas', 'ASC')->get();
        return view('kas.tambahkas', [
            'kas' => $kas,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
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

    public function ekas(Request $request, $id)
    {
        $data = Bukukas::where('id', $id)->first();

        if ($request->bk_kas == $data->bk_kas) {
            if ($request->tipe == $data->tipe) {
                $this->validate($request, [
                    'bk_kas' => 'unique:bukukas',
                ]);
            }
            Bukukas::where('id', $request->id,)->update([
                'bk_kas' => $request->bk_kas,
                'tipe' => $request->tipe
            ]);
            return redirect('/main/kas')->with('success', 'Kas berhasil diubah.');
        } else {
            $this->validate($request, [
                'bk_kas' => 'unique:bukukas',
            ]);
            Bukukas::where('id', $request->id,)->update([
                'bk_kas' => $request->bk_kas,
                'tipe' => $request->tipe
            ]);
            return redirect('/main/kas')->with('success', 'Kas berhasil diubah.');
        }
    }

    public function dkas($id)
    {
        Bukukas::where('id', $id)->delete();
        return redirect('/main/kas')->with('success', 'Kas berhasil dihapus.');;
    }

    // Reset Buku Kas
    public function delkas()
    {
        if (Bukukas::exists()) {
            Bukukas::query()->delete();
            File::deleteDirectory(public_path('/assets/image'));
            return redirect()->back()->with('success', 'Reset data buku kas berhasil');
        } else {
            return redirect()->back()->with('warning', 'Proses ditolak karena data kosong');
        }
    }
}
