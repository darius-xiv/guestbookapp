<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FilipayUsers;

class LoginController extends Controller
{
    public function login()
    {
        if (session('login_auth')) {
            return redirect("/dashboard");
        } else {
            return view("/login_page");
        }
    }

    public function login_attempt(Request $request)
    {
        $details = array(
            'username' => request('username'),
            'password' => request('password')
        );

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username_exist = FilipayUsers::where('username', $details['username']); // To make shorthand method
        if ($username_exist->exists() && password_verify($details['password'], $username_exist->first()->password)) { // Verify hashed fetched password value from DB
            $get_details = $username_exist->first();

            session([
                'login_auth' => TRUE,
                'exist_id' => $get_details->id,
                'first_name' => $get_details->first_name,
                'last_name' => $get_details->last_name,
                'gender' => $get_details->gender,
                'b_day' => $get_details->b_day,
                'profile_picture_path' => $get_details->profile_picture_path,
                'username' => $get_details->username
            ]);
            return redirect('/dashboard');

        } else {
            (session()->has('username')) ? session()->flush() : FALSE;
            session(['form_validation' => 'Incorrect credentials!']);
            return redirect('/login');
        }
    }

    public function signUp(Request $request)
    {
        $details = new FilipayUsers();

        $details->username = request('username');
        $details->first_name = request('first_name');
        $details->last_name = request('last_name');
        $details->password = password_hash(request('password'), PASSWORD_DEFAULT); // PHP Default Hash
        $details->b_day = request('b_day');
        $details->gender = request('gender');

        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'b_day' => 'required|before:tomorrow',
            'gender' => 'required',
            'username' => 'required|alpha_dash|unique:filipay_users,username',
            'password' => 'required'
        ]);

        $details->save(); // Auto insert to DB filipay_users

        (session()->has('form_validation')) ? session()->flush() : FALSE;
        session()->flash('success', 'You have successfully registered an account.'); // Testing flash sessions
        return redirect('/login');
    }
}
