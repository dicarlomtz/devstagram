<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, User $user, Post $post)
    {

        $rules = [
            'comment' => ['required', 'max:255']
        ];

        $customMessages = [
            'required' => 'Your :attribute is required',
            'comment.max' => 'Your :attribute cannot have more than 255 characters'
        ];

        $this->validate($request, $rules, $customMessages);

        Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment' => $request->comment
        ]);

        return back()->with('added', 'Comment added');

    }
}
