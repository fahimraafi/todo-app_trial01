<div>
    <div id="content" class="mx-auto" style="max-width:500px;">
        <div class="container content py-6 mx-auto">
            <div class="mx-auto">

                @include('livewire.includes.create-todo-box')

            </div>
        </div>
        @include('livewire.includes.searchbox-todo')

        {{-- Pagination --}}

        <div class="my-2">
            {{ $todos->links() }}
        </div>
        {{-- Pagination --}}

        @foreach ($todos as $todo)
            @include('livewire.includes.todo-card')
        @endforeach


    </div>
</div>
