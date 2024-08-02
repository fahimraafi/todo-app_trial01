<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Todo;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Validate('required|min:3')]
    public $name;

    public $search;


    public function create(){

        $validated = $this->validateOnly('name');

        Todo::create($validated);
        session()->flash('success','Successfully created');

    }
    public function render()
    {
        return view('livewire.todo-list', [
            "todos" => Todo::latest()->paginate(5),
        ]);
    }
}
