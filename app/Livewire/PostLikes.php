<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostReactions;

class PostLikes extends Component
{
    public Post $post;

    public function like()
    {
        $user = auth()->user();
        
        if (!$user) {
            $this->dispatch('toastify', ['message'=>'You must be logged in to dislike this post']);
            return;
        }
        if ($user->id === $this->post->user_id) {
            $this->dispatch('toastify', ['message' => 'You cannot dislike your own post']);
            return;
        }

        if ($this->post->reactions()->where('user_id', $user->id)->exists()) {
            $this->dispatch('toastify', ['message' => 'Already reacted']);
            return;
        }
        PostReactions::create([
            'post_id' => $this->post->id,
            'user_id' => $user->id,
            'type'    => 'like',
        ]);
    }

    public function dislike()
    {
        $user = auth()->user();
        if (!$user) {
            $this->dispatch('toastify', ['message'=>'You must be logged in to dislike this post']);
            return;
        }
        if ($user->id === $this->post->user_id) {
            $this->dispatch('toastify', ['message' => 'You cannot dislike your own post']);
            return;
        }

        if ($this->post->reactions()->where('user_id', $user->id)->exists()) {
            $this->dispatch('toastify', ['message' => 'Already reacted']);
            return;
        }

        PostReactions::create([
            'post_id' => $this->post->id,
            'user_id' => $user->id,
            'type'    => 'dislike',
        ]);
    }

    public function render()
    {
        return view('livewire.post-likes');
    }
}
