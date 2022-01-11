<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EditController extends Controller
{
    public function editakun()
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
        if(empty($pecah[1])){
            $surname = "";
        }else{
            $surname = $pecah[1]; 
        }
        
        return view('editakun.viewedit',[
            'forename' => $forename,
            'surname' => $surname,
            'year' => $year
        ]);
    }

    public function posteditakun(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|alpha_num|min:5|max:10',
            'name' => 'required|min:3|max:35',
            'telp' => 'numeric|digits_between:10,13',
            'email' => 'required|email',
        ]);


        User::where('id', $request->id)->update([
            'username' => $request->username,
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
                $this->validate($request, [
                    'image' => 'mimes:jpeg,jpg,png,gif|required|max:20000'
                ]);

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
                $this->validate($request, [
                    'image' => 'mimes:jpeg,jpg,png,gif|required|max:20000'
                ]);

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
