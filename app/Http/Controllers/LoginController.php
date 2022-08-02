<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request) 
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];

        $customMessages = [
            'required' => 'Your :attribute is required',
            'email' => 'Your :attribute is not a valid email'
        ];

        if(!auth()->attempt($request->only('email', 'password'), $request->remember))
        {
            return back()->with('message', 'Wrong credentials');
        }

        $this->validate($request, $rules, $customMessages);

        return redirect()->route('posts.index', auth()->user()->username);
    }

}
