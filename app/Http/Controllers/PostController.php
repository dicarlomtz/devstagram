<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth')->except(['show', 'index']);
    }
    
    public function index(User $user)
    {

        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create(User $user)
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'image' => ['required']
        ];

        $customMessages = [
            'required' => 'Your :attribute is required',
            'title.max' => 'Your :attribute cannot have more than 255 characters',
        ];

        $this->validate($request, $rules, $customMessages);

      /*   Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'user_id' => auth()->user()->id
        ]); */

        # Different approach to save data
      /*   
        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = $request->image;
        $post->user_id = auth()->user()->id; 
        $post->save();
    */

        $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);

    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
       $this->authorize('delete', $post);
        $post->delete();

        $image_path = public_path('uploads' . '/' . $post->image);

        if(File::exits($image_path))
        {
            unlink($image_path);
        }

        return redirect()->route('posts.index', auth()->user()->username);

    }

}
