<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasIndex;
use App\Models\Catagory;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CatagoryFiltersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function selecting_a_catagory_filters_correctly()
    {
        $user = User::factory()->create();

        $catagoryOne = Catagory::factory()->create(['name' => 'Catagory 1']);
        $catagoryTwo = Catagory::factory()->create(['name' => 'Catagory 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryTwo->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('catagory', 'Catagory 1')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->catagory->name === 'Catagory 1';
            });
    }

    /** @test */
    public function the_catagory_query_string_filters_correctly()
    {
        $user = User::factory()->create();

        $catagoryOne = Catagory::factory()->create(['name' => 'Catagory 1']);
        $catagoryTwo = Catagory::factory()->create(['name' => 'Catagory 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryTwo->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        Livewire::withQueryParams(['catagory' => 'Catagory 1'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->catagory->name === 'Catagory 1';
            });
    }

    /** @test */
    public function selecting_a_status_and_a_catagory_filters_correctly()
    {
        $user = User::factory()->create();

        $catagoryOne = Catagory::factory()->create(['name' => 'Catagory 1']);
        $catagoryTwo = Catagory::factory()->create(['name' => 'Catagory 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryTwo->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaFour = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryTwo->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('status', 'Open')
            ->set('catagory', 'Catagory 1')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->catagory->name === 'Catagory 1'
                    && $ideas->first()->status->name === 'Open';
            });
    }

    /** @test */
    public function the_catagory_query_string_filters_correctly_with_status_and_catagory()
    {
        $user = User::factory()->create();

        $catagoryOne = Catagory::factory()->create(['name' => 'Catagory 1']);
        $catagoryTwo = Catagory::factory()->create(['name' => 'Catagory 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryTwo->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaFour = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryTwo->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        Livewire::withQueryParams(['status' => 'Open', 'catagory' => 'Catagory 1'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->catagory->name === 'Catagory 1'
                    && $ideas->first()->status->name === 'Open';
            });
    }

    /** @test */
    public function selecting_all_catagories_filters_correctly()
    {
        $user = User::factory()->create();

        $catagoryOne = Catagory::factory()->create(['name' => 'Catagory 1']);
        $catagoryTwo = Catagory::factory()->create(['name' => 'Catagory 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My Second Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'catagory_id' => $catagoryTwo->id,
            'status_id' => $statusOpen->id,
            'title' => 'My Third Idea',
            'description' => 'Description for my first idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('catagory', 'All Catagories')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 3;
            });
    }
}