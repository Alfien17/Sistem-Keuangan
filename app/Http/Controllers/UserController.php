<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function user()
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

        $user = User::get();
        return view('user.user', [
            'user' => $user,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function euser(Request $request)
    {
        User::where('id',$request->id)->update(['bagian' => $request->bagian]);
        return redirect()->back()->with('success', 'Bagian berhasil diubah.');
    }

    public function detailuser ($id)
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

        $user = User::where('id',$id)->get();
        return view('user.detailuser', [
            'user' => $user,
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function duser($id)
    {
        if ($id == '1') {
            return redirect()->back()->with('warning', 'User tidak bisa dihapus');
        }else{
            User::where('id', $id)->delete();
            return redirect()->back()->with('success', 'User berhasil dihapus');
        }
    }
}
