<?php

namespace App\Http\Livewire;

use App\Models\Catagory;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Vote;
use Livewire\Component;
use App\Http\Livewire\Traits\WithAuthRedirects;
use Livewire\WithPagination;

class IdeasIndex extends Component
{
    use WithPagination,WithAuthRedirects;

    public $status;
    public $catagory;
    public $filter;
    public $search;

    protected $queryString = [
        'status',
        'catagory',
        'filter',
        'search',
    ];

    protected $listeners = ['queryStringUpdatedStatus'];

    public function mount()
    {
        $this->status = request()->status ?? 'All';
    }

    public function updatingCatagory()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        if($this->filter == 'My Ideas'){
            if(auth()->guest()){
                return $this->redirectToLogin();
            }
        }
    }

    public function queryStringUpdatedStatus($newStatus)
    {
        $this->resetPage();
        $this->status = $newStatus;
    }

    public function render()
    {
        $statuses = Status::all()->pluck('id','name');
        $catagories = Catagory::all();

        
        return view('livewire.ideas-index', [
            'ideas' => Idea::with('user', 'catagory', 'status')
                ->when($this->status && $this->status!= 'All', function ($query) use ($statuses){
                    return $query->where('status_id', $statuses->get($this->status));
                })->when($this->catagory && $this->catagory!= 'All Catagories', function ($query) use ($catagories){
                    return $query->where('catagory_id', $catagories->pluck('id', 'name')->get($this->catagory));
                })->when($this->filter && $this->filter == 'Top Voted', function ($query){
                    return $query->orderByDesc('votes_count');
                })->when($this->filter && $this->filter == 'My Ideas', function ($query){
                    return $query->where('user_id', auth()->id());
                })->when($this->filter && $this->filter === 'Spam Ideas', function ($query) {
                    return $query->where('spam_report', '>', 0)->orderByDesc('spam_report');
                })->when($this->filter && $this->filter === 'Spam Comments', function ($query) {
                    return $query->whereHas('comments', function($query) {
                        $query->where('spam_report', '>', 0);
                    });
                })->when(strlen($this->search) >= 3, function ($query){
                    return $query->where('title', 'like', '%'.$this->search.'%');
                })
                ->addSelect(['voted_by_user' => Vote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('idea_id', 'ideas.id')
                ])
                ->withCount('votes')
                ->withCount('comments')
                ->orderBy('id','desc')
                ->simplePaginate()
                ->withQueryString(),
            'catagories' => $catagories,
        ]);
    }
    
}
