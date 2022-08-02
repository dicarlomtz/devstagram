<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.index');
    }

    public function store(Request $request)
    {

        $request->request->add(['username' => Str::slug($request->username)]);

        $rules = [
            'username' => ['required', 'min:3', 'max:20', 'unique:users,username,'.auth()->user()->id],
        ];

        $customMessages = [
            'required' => 'Your :attribute is required',
            'username.min' => 'Your :attribute must have 3 characters at least',
            'username.max' => 'Your :attribute cannot have more than 20 characters',
            'unique' => ':attribute already exists'
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::find(auth()->user()->id);

        $user->username = $request->username;
        $user->image = $request->image ? $this->saveProfileImage($request) : auth()->user()->image;
        $user->save();

        return redirect()->route('posts.index', $user->username);
    }

    private function saveProfileImage(Request $request)
    {
        $image = $request->file('image');

        $imageName = Str::uuid() . '.' . $image->extension();

        $imageServicer = Image::make($image);
        $imageServicer->fit(1000, 1000);

        $imagePath = public_path('profiles') . '/' . $imageName;
        $imageServicer->save($imagePath);

        return $imageName;
    }
}
