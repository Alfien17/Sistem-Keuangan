<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EditController extends Controller
{
    public function editakun($id)
    {
        // Check Login
        if (!Auth::user()) {
            return redirect('/login');
        }

        $auth = Auth::user();
        $nama = $auth->name;
        $pecah = explode(' ', $nama);
        $forename = $pecah[0];
        if(empty($pecah[1])){
            $surname = "";
        }else{
            $surname = $pecah[1]; 
        }
        
        $akun = User::where('id', $id)->get();
        return view('editakun.viewedit',[
            'akun' => $akun,
            'forename' => $forename,
            'surname' => $surname
        ]);
    }

    public function posteditakun(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:35',
            'telp' => 'numeric|digits_between:10,13',
            'email' => 'required|email',
        ]);


        User::where('id', $request->id)->update([
            'name' => $request->name,
            'telp' => $request->telp,
            'email' => $request->email,
            'al_detail' => $request->al_detail
        ]);
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function imageakun(Request $request, $id)
    {
        $image = User::where('id', $id)->first();
        if ($image->image != 'default/default2.png') {
            if ($request->hasfile('image')) {
                File::delete(public_path() . '/assets/' . $image->image);
                $image = $request->file('image');
                $imageName = "profile/" . time() . "_" . $image->getClientOriginalName();
                $imgLoc = 'assets/profile';
                $image->move($imgLoc, $imageName);
                User::where('id', $id)->update(['image' => $imageName]);
                return redirect()->back()->with('s_eimg', 'Gambar berhasil diubah');
            } 
        }else {
            if ($request->hasfile('image')) {
                $image = $request->file('image');
                $imageName = "profile/" . time() . "_" . $image->getClientOriginalName();
                $imgLoc = 'assets/profile';
                $image->move($imgLoc, $imageName);
                User::where('id', $id)->update(['image' => $imageName]);
                return redirect()->back()->with('s_eimg', 'Gambar berhasil diubah');
            }
        }
    }

    public function dprofile($id)
    {
        $image = User::where('id', $id)->first();
        if ($image->image != 'default/default2.png') {
            File::delete(public_path() . '/assets/' . $image->image);
            User::where('id', $id)->update([
                'image' => 'default/default2.png'
            ]);
            return redirect()->back()->with('s_dimg', 'Gambar berhasil dihapus');
        } else {
            return redirect()->back()->with('g_img', 'Gambar tidak dapat ditemukan');
        }
    }
}
