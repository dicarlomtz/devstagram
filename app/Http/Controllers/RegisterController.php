<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request) 
    {

        $rules = [
            'name' => ['required', 'max:30'],
            'username' => ['required', 'min:3', 'max:20', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8']
        ];

        $customMessages = [
            'required' => 'Your :attribute is required',
            'name.max' => 'Your :attribute cannot have more than 30 characters',
            'username.min' => 'Your :attribute must have 3 characters at least',
            'username.max' => 'Your :attribute cannot have more than 20 characters',
            'confirmed' => 'Confirmation password does not match',
            'password.min' => 'Your :attribute must have 8 characters at least',
            'email' => 'Your :attribute is not a valid email',
            'unique' => ':attribute already exists'
        ];

        $this->validate($request, $rules, $customMessages);

        User::create([
            'name' => $request->name,
            'username' => Str::slug($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        auth()->attempt($request->only('email', 'password'));

        return redirect()->route('posts.index');

    }
}
