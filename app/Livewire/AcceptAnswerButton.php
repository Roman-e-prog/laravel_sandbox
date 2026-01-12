<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Answer;
use App\Models\Post;

class AcceptAnswerButton extends Component
{
    public Answer $answer;
    public Post $post;

    public function mount(Answer $answer, Post $post)
    {
        $this->answer = $answer;
        $this->post = $post;
    }

    public function accept()
{
    // Only the owner of the post can accept an answer
    if (auth()->id() !== $this->post->user_id) {
        $this->dispatch('toast', message: 'Thats not your post', type: 'error');
        return;
    }

    // Mark answer as accepted
    $this->answer->update([
        'has_answered' => true,
    ]);

    // Mark post as answered
    $this->post->update([
        'is_answered' => true,
    ]);

    // Refresh component state
    $this->answer->refresh();
    $this->post->refresh();
}


    public function render()
    {
        return view('livewire.accept-answer-button');
    }
}
