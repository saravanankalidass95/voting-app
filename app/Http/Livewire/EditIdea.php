<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use App\Models\Catagory;
use Illuminate\Http\Response;
use Livewire\Component;

class EditIdea extends Component
{
    public $idea;
    public $title;
    public $catagory;
    public $description;

    protected $rules = [
        'title' => 'required|min:4',
        'catagory' => 'required|integer|exists:catagories,id',
        'description' => 'required|min:4',
    ];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->title = $idea->title;
        $this->catagory = $idea->catagory_id;
        $this->description = $idea->description;
    }

    public function updateIdea()
    {
        if (auth()->guest() || auth()->user()->cannot('update', $this->idea)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $this->idea->update([
            'title' => $this->title,
            'catagory_id' => $this->catagory,
            'description' => $this->description,
        ]);

        $this->emit("ideaWasUpdated", 'Idea was updated successfully!');
    }

    public function render()
    {
        return view('livewire.edit-idea',[
            'catagories' => Catagory::all(),
        ]);
    }
}
