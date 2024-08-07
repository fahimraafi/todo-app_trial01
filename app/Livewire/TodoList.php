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

    public $editingTodoID;

    #[Validate('required|min:3')]
    public $editingName;


    public function create(){

        $validated = $this->validateOnly('name');

        Todo::create($validated);
        session()->flash('success','Successfully created');
        $this->resetPage();

    }

    public function delete(Todo $todo)
    {

        Todo::find($todo->id)->delete();

    }

    public function toggle($todoID)
    {
        $todo = Todo::findOrFail($todoID);

        $todo->status =!$todo->status;
        $todo->save();

    }


    public function edit($todoID)
    {
        $this->editingTodoID = $todoID;
        $this->editingName = Todo::find($todoID)->name;


    }

    public function update()
    {
        $this->validateOnly('editingName');

        Todo::find($this->editingTodoID)->update(
            [
                'name' => $this->editingName,
            ]
        );

        $this->cancelEdit();
        session()->flash('updated', 'Updated Successfully');
    }


    public function cancelEdit()
    {
        $this->reset('editingTodoID', 'editingName');


    }

    public function render()
    {
        $searchbox = Todo::latest()->where('name', 'like', "%{$this->search}%");

        return view('livewire.todo-list', [
            "todos" => $searchbox->paginate(5),
        ]);
    }
}
