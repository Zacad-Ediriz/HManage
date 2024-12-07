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
            return response("Wrong username and or password!!!", 401);
        }

        $request->session()->regenerate();
        // return redirect('/dashbourd');
        $user = Auth::user();
        if ($user->type == 'user') {
            return redirect('/userdashboard');
        } else {
            return redirect('/dashbourd');
        }
    }




    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route("/");
    }

}
