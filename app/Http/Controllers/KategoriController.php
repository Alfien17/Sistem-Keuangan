<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Kategori;
use Illuminate\Support\Facades\File; 

class KategoriController extends Controller
{
    public function tambahkat()
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
        return view('kategori.tambahkat', [
            'kat' => $kat,
            'surname' => $surname,
            'forename' => $forename,
            'year' => $year
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

    public function dkat($id)
    {
        Kategori::where('id', $id)->delete();
        return redirect('/main/kategori')->with('success', 'Kategori berhasil dihapus');
    }

    // Reset Kategori
    public function delkat()
    {
        if (Kategori::exists()) {
            Kategori::query()->delete();
            File::deleteDirectory(public_path('/assets/image'));
            return redirect()->back()->with('success', 'Reset data kategori berhasil');
        } else {
            return redirect()->back()->with('warning', 'Proses ditolak karena data kosong');
        }
    }
}
