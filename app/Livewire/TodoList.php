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
        $this->reset();
        session()->flash('success','Successfully created');

    }

    public function delete(Todo $todo){
        Todo::find($todo->id)->delete();
    }

    public function render()
    {
        return view('livewire.todo-list', [
            "todos" => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5),
        ]);
    }
}
