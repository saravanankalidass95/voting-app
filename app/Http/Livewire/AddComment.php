<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use App\Models\Comment;
use App\Notifications\commentAdded;
use Illuminate\Http\Response;
use App\Http\Livewire\Traits\WithAuthRedirects;
use Livewire\Component;

class AddComment extends Component
{ 
    use WithAuthRedirects;

    
    public $idea;
    public $comment;
    protected $rules = [
        'comment' => 'required|min:4',
    ];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function addComment()
    {
        if(auth()->guest()){
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $newComment = Comment::create([
            'user_id' => auth()->id(),
            'idea_id' => $this->idea->id,
            'status_id' => 1,
            'body' => $this->comment
        ]);

        $this->reset('comment');

        $this->idea->user->notify(new commentAdded($newComment));

        $this->emit('commentWasAdded', 'Comment was posted!');
    }


    public function render()
    {
        return view('livewire.add-comment');
    }
}
