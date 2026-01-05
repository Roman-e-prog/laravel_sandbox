<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Answer;
use App\Models\PostReactions;

class AnswerLikes extends Component
{
     public Answer $answer;
    
    public function like()
    {
        $user = auth()->user();
        if (!$user) {
            $this->dispatch('toastify', ['message'=>'You must be logged in to like this answer']);
            return;
        }
     
        if ($user->id === $this->answer->user_id) {
            $this->dispatch('toastify', ['message' => 'You cannot like your own answer']);
            return;
        }

        if ($this->answer->reactions()->where('user_id', $user->id)->exists()) {
            $this->dispatch('toastify', ['message' => 'Already reacted']);
            return;
        }

        PostReactions::create([
            'answer_id' => $this->answer->id,
            'user_id' => $user->id,
            'type'    => 'like',
        ]);
    }

    public function dislike()
    {
        $user = auth()->user();
        if (!$user) {
            $this->dispatch('toastify', ['message'=>'You must be logged in to dislike this answer']);
            return;
        }
        if ($user->id === $this->answer->user_id) {
            $this->dispatch('toastify', ['message' => 'You cannot dislike your own answer']);
            return;
        }

        if ($this->answer->reactions()->where('user_id', $user->id)->exists()) {
            $this->dispatchBrowserEvent('toastify', ['message' => 'Already reacted']);
            return;
        }

        PostReaction::create([
            'answer_id' => $this->answer->id,
            'user_id' => $user->id,
            'type'    => 'dislike',
        ]);
    }
    public function render()
    {
        return view('livewire.answer-likes');
    }
}
