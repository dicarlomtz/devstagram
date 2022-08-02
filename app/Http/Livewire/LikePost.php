<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class LikePost extends Component
{

    public Post $post;
    public $liked;
    public $likes; 

    public function mount($post)
    {
        $this->liked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        if($this->post->checkLike(auth()->user()))
        {
            $this->post->likes()->where('user_id', auth()->user()->id)->delete();
            $this->liked = false;
            $this->likes--;
        } else 
        {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->liked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
