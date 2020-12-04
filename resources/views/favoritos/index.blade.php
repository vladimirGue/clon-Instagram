<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Larafoto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1>Mis imagenes favoritas</h1>

                @foreach($likes as $like) 
                    @livewire('card', ['image' => $like->image])
                @endforeach
                <!--Pagination-->
                <div class="clearfix"></div>
                {{$likes->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
