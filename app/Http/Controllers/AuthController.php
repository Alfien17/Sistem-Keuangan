<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;


class AuthController extends Controller
{
    public function showFormLogin()
    {
        $year = Carbon::now()->format('Y');
        if (Auth::check()) 
        {
            $auth = Auth::user();
            if ($auth->status_vrf == '0') 
            {
                return redirect('/main');
            }
        }
        return view('login',['year'=>$year]);
    }

    public function login(Request $request)
    {
        $rules = [
            'username'              => 'required|alpha_num',
            'password'              => 'required|string'
        ];
        $messages = [
            'username.alpha_num'    => 'Username hanya diisi dengan huruf dan angka!',
            'username.required'     => 'Username wajib diisi!',
            'password.required'     => 'Password wajib diisi!',
            'password.string'       => 'Password harus berupa string!'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        $data = [
            'username'  => $request->username,
            'password'  => $request->password,
        ];
        Auth::attempt($data);

        if (Auth::check()) 
        {
            $auth = Auth::user();
            if ($auth->status_vrf == '0')
            {
                $nama = $auth->name;
                $pecah = explode(' ', $nama);
                $forename = $pecah[0];
                if (empty($pecah[1])) {
                    $surname = "";
                } else {
                    $surname = $pecah[1];
                }
                return redirect('/main')->with('success', 'Selamat Datang, ' . $forename . ' ' . $surname);
            } 
            else 
            {
                Session::flash('error', 'Anda belum melakukan verifikasi email!');
                return redirect()->back();
            }
        }
        else
        {
            Session::flash('error', 'Username atau Password salah');
            return redirect()->back();
        }
    }

    public function showFormRegister()
    {
        $year = Carbon::now()->format('Y');
        return view('register',['year'=>$year]);
    }

    public function register(Request $request)
    {
        $rules = [
            'username'              => 'required|alpha_num|min:5|max:10|unique:users',
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed'
        ];

        $messages = [
            'username.required'     => 'Username wajib diisi',
            'username.alpha_num'    => 'Username hanya diisi dengan huruf dan angka!',
            'username.min'          => 'Username minimal 5 karakter',
            'username.max'          => 'Username maksimal 10 karakter',
            'username.unique'       => 'Username sudah terdaftar',
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        $now = date('Y-m-d H:i:s');
        $limit = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime($now)));

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status_update' => '0',
            'status_vrf' => '1',
            'bagian' => 'supervisor',
            'image' => 'default/default2.png',
            'encrypt_id' => Crypt::encrypt($request->email),
            'expired_time' => $limit
        ]);
        
        $user = User::where('email', $request->email)->get();
        $nama = $request->name;
        $email = $request->email;
            Mail::send('editakun.link2',['user' => $user],
            function ($mail) use ($email, $nama) {
                $mail->to($email, 'Admin IAC')
                    ->subject('Hi ' . $nama. ', Verification Your Account');
            }
        );
        return redirect()->back()->with('success', 'Link verifikasi berhasil terkirim ke email Anda. Silahkan cek email. Batas verifikasi email adalah 2 jam');
    }

    public function verifikasi($encrypt_id)
    {
        $data = Crypt::decrypt($encrypt_id);
        $user = User::where('email', $data)->get();
        $find_email = User::where('email', $data)->first();
        $year = Carbon::now()->format('Y');

        if ($find_email->expired_time >= date("Y-m-d H:i:s")) {
            if ($find_email->status_vrf == '1' && $find_email->encrypt_id == $encrypt_id) {
                return view('editakun.verifikasi', ['user' => $user, 'year' => $year]);
            } else {
                return view('editakun.gagal2', ['year' => $year]);
            }
        } else {
            return view('editakun.gagal2', ['year' => $year]);
        }
    }

    public function postverif($id)
    {
        $email = User::where('id', $id)->first();
        User::where('email', $email->email)->update(['status_vrf' => '0']);
        return redirect()->back()->with('success', 'Verifikasi email berhasil.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success','Logout berhasil');
    }

    public function editpsw(Request $request)
    {
        $email = $request->email;
        $data = User::where('email', $request->email)->first();
        $now = date('Y-m-d H:i:s');
        $limit = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime($now)));

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            User::where('email', $request->email)->update([
                'status_update' => '1',
                'encrypt_id' => Crypt::encrypt($data->id),
                'expired_time' => $limit
            ]);
            $user = User::where('email', $request->email)->get();
            Mail::send('editakun.link',['user' => $user],
                function($mail) use($email,$data){
                    $mail->to($email,'Admin IAC')
                    ->subject('Hi '.$data->name.', Update your Password');
                }
            );
            return redirect()->back()->with('success','Link berhasil terkirim ke email Anda. Silahkan cek email.');
        } else
            return redirect()->back()->with('fail2', 'Email tidak terdaftar.');
    }

    public function password($encrypt_id)
    {
        $data = Crypt::decrypt($encrypt_id);
        $user = User::where('id', $data)->get();
        $find_id = User::where('id',$data)->first();
        $year = Carbon::now()->format('Y');

        if($find_id->expired_time >= date("Y-m-d H:i:s")){
            if($find_id->status_update == '1' && $find_id->encrypt_id == $encrypt_id){
                return view('editakun.password', ['user' => $user, 'year' => $year]); 
            } else {
                return view('editakun.gagal', ['year' => $year]);
            }
        }else{
            return view('editakun.gagal', ['year' => $year]);
        }
    }

    public function postpassword(Request $request, $id)
    {
        $email = User::where('id', $id)->first();

        $this->validate($request, [
            'password' => 'required|confirmed|min:5'
        ]);

        User::where('email', $email->email)->update([
            'password' => bcrypt($request->password),
            'status_update' => '0'
        ]);
        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

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
        if (empty($pecah[1])) {
            $surname = "";
        } else {
            $surname = $pecah[1];
        }

        return view('editakun.viewedit', [
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
        } else {
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
