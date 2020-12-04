<div>{{--Evitar quitar este div en un componente--}}
    <div class="flex items-center sm:ml-32 lg:sm-64 ml-0">
        <img src="{{ $user->profile_photo_url }}" class="rounded-full h-40 w-40 flex items-center justify-center" alt="">
        <div class="text-lg pl-2">
                <p class="text-2xl leading-none font-bold mb-5">{{ $user->name}}
                    <span class="font-normal">
                    {{ ' | @'.$user->nick }}
                    </span>
                </p>
            <div class="flex">
                <p class="bg-gray-200 mr-2 rounded-full py-2 px-4"><span class="font-bold">Correo: </span>{{$user->email}}</p>
                <p class="bg-gray-200 rounded-full py-2 px-4"><span>{{'publicaciones '.count($user->images)}}</span></p>
            </div>
            {{--Mostrar hace cuanto se registro el usuario--}}
            <p class="text-gray-600">Se unio {{ \FormatTime::LongTimeFilter($user->created_at)}}</p>
        </div>
    </div>

    <div  class="grid grid-cols-3 gap-4 py-10 px-10" x-data="{ open: false }">
        {{--Muestro la galeria de imagenes--}}
        @foreach ($user->images as $img)
        
            <a @click=" open = true" wire:click="$emit('newPost', {{$img->id}})"  style="cursor: pointer">
                <img src="{{route('image.file', ['filename' => $img->image_path])}}" class="rounded" alt="">
            </a>
            
        @endforeach
        {{--Integro el componente modal--}}
        @livewire('modal')
    </div>
</div>
