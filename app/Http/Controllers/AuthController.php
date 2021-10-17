<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;


class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect('/main');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];

        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            $auth = Auth::user();
            $nama = $auth->name;
            $pecah = explode(' ', $nama);
            $forename = $pecah[0];
            if (empty($pecah[1])) {
                $surname = "";
            } else {
                $surname = $pecah[1];
            }

            return redirect('/main')->with('success', 'Selamat Datang, ' . $forename . ' ' . $surname);
        } else { // false

            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }
    }

    public function showFormRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed'
        ];

        $messages = [
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

        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->image = 'default/default2.png';
        $simpan = $user->save();

        if ($simpan) {
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login')->with('success','Logout berhasil');
    }

    public function editpsw(Request $request)
    {
        $email = $request->email;
        $name = User::where('email', $request->email)->first();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            $user = User::where('email', $request->email)->get();
            // Mail::to($email)->send(new TestMail($details));
            // $this->password($user->id);
            Mail::send('editakun.link',['user' => $user],
                function($mail) use($email,$name){
                    $mail->to($email,'Admin IAC')
                    ->subject('Hi '.$name->name.', Update your Password');
                }
            );
            return redirect()->back()->with('success','Link berhasil terkirim ke email Anda. Silahkan cek email.');
        } else
            return redirect()->back()->with('fail2', 'Email tidak terdaftar.');
    }

    public function link(){
        return view('editakun.link');
    }

    public function password($id){
        $data = Crypt::decrypt($id);
        $user = User::where('id',$data)->get();
        return view('editakun.password',['user' => $user]);
    }

    public function postpassword(Request $request, $id)
    {
        $email = User::where('id', $id)->first();

        $this->validate($request, [
            'password' => 'required|confirmed|min:5'
        ]);

        User::where('email', $email->email)->update(['password' => bcrypt($request->password)]);
        return view('editakun.success');
    }
}
