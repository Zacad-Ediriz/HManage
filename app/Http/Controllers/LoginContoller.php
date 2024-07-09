<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class LoginContoller extends Controller
{
    function index()
    {
        return view('Auth.Login.index');
    }

    function login(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);

        if (!Auth::attempt($data)) {
            return response("Wrong username and/or password!!!", 401);
        }
        // $request->session()->put("userid", auth()->user()->id);
        // $request->session()->put("site_id", 1);
        $request->session()->regenerate();
        return response(200);

        // $user = User::where('email', $request->email);

        // if ($user->exists() && Hash::check($request->password, $user->first()->password)) {
        //     if (env('has_otp') == '1') {
        //         if ($user->first()->has_otp == 1) {
        //             $request->session()->put('tmp_usr', $user->first());
        //             $code = rand(0, 1000000);
        //             $msg = "You OTP is - $code";
        //             $request->session()->put('fa_code', $code);
        //             (new Smslibrary())->sendtemplate($user->first()?->phone, $msg);
        //             // Utility::sendSms($user->first()->mobile, $msg);
        //         } else {
        //             $request->session()->put("userid", auth()->user()->id);
        //             $request->session()->put("site_id", auth()->user()->site_id);
        //             Auth::login($user->first());
        //         }
        //     } else {
        //         if ($user->first()->is_first_time == "1") {
        //             $request->session()->put('tmp_usr', $user->first());
        //             $request->session()->put('is_first', 1);
        //         } else {
        //             Auth::login($user->first());
        //             $request->session()->regenerate();
        //             $request->session()->put("userid", auth()->user()->id);
        //             $request->session()->put("site_id", auth()->user()->site_id);
        //             return response(url('/dashboard'), 200);
        //         }
        //     }
        // } else {
        //     return response("Wrong username and/or password!!!", 401);
        // }


        // $user = \Session::get('tmp_usr');
        // $is_first = \Session::get('is_first') ?? 0;
        // $fa_code = \Session::get('fa_code');
        // if ($user && $fa_code) {
        //     // return redirect()->to(route('2fa'));
        //     return response(route('2fa'), 200);
        // } else if ($user && $is_first == 1) {
        //     // return redirect()->to(route('change_password'));
        //     return response(route('change_password'), 200);
        // } else {
        //     $request->session()->regenerate();
        //     $request->session()->put("userid", auth()->user()->id);
        //     $request->session()->put("site_id", auth()->user()->site_id);
        //     return response(url('/dashboard'), 200);
        // }




        // if (!Auth::attempt($data)) {
        //     return response("Wrong username and/or password!!!", 401);
        // }
        // $request->session()->put("userid", auth()->user()->id);
        // $request->session()->put("site_id", 1);
        // return response(200);

    }




    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route("login");
    }

}
