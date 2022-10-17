<?php

namespace App\Http\Livewire;

use App\Models\Vote;
use App\Models\Catagory;
use App\Models\Idea;
use Illuminate\Http\Response;
use App\Http\Livewire\Traits\WithAuthRedirects;
use Livewire\Component;

class CreateIdea extends Component
{
    use WithAuthRedirects; 

    public $title;
    public $catagory = 1;
    public $description;

    protected $rules = [
        'title' => 'required|min:4',
        'catagory' => 'required|integer|exists:catagories,id',
        'description' => 'required|min:4',
    ];

    public function createIdea()
    {
        if(auth()->guest()){
            abort(Response::HTTP_FORBIDDEN);
        }


        
            $this->validate();

            $idea = Idea::create([
                'user_id' => auth()->id(),
                'catagory_id' => $this->catagory,
                'status_id' => 1,
                'title' => $this->title,
                'description' => $this->description,
            ]);

            $idea->vote(auth()->user());

            // Vote::create([
            //     'idea_id' => $idea->id,
            //     'user_id' => auth()->id(),
            // ]);

            session()->flash('success_message', 'Idea was added successfully!');

            $this->reset();

            return redirect()->route('idea.index');
        

        
    }

    public function render()
    {
        return view('livewire.create-idea', [
            'catagories' => Catagory::all(),
        ]);
    }
}
