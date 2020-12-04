<div>
    {{--controlador para visualizar lista de usuarios registrados--}}
        <x-jet-input type="text" wire:model="search" class="mt-1 sm:ml-28 w-2/5 mb-12 mr-2" placeholder="{{ __('Search') }}"/>
        
    @foreach ($users as $user)
        <div class="flex items-center sm:ml-32 lg:sm-64 ml-0 mb-10">
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
                <p class="text-gray-600 mb-4">Se unio {{ \FormatTime::LongTimeFilter($user->created_at)}}</p>
                <a href="{{route('user.profile', ['id' => $user->id])}}" class="text-base font-medium rounded-lg bg-blue-400 hover:bg-blue-500 text-white p-3">Visitar perfil</a>
            </div>
        </div>
    @endforeach
    {{$users->links()}}
</div>
