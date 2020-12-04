<div>
    {{--Comprobar si el objeto image existe y no esta vacio--}}
    @if (isset($image) && $image != '')
        @php
        //si existe y no esta vacio se vacia en el array images_detail
            $images_detail = ['imgs' => $image];
        @endphp
    @else
    {{--caso contrario agrego el objeto dentro del array imgs al array images_detail--}}
        @foreach ($images as $image)
            @if ($image->id == ($id_img ?? $image->id)) 
                @php
                    $images_detail = ['imgs' => $image];
                @endphp
            @endif
        @endforeach
    @endif
    
            {{--Body del modal en forma horizontal--}}
            <div class="rounded overflow-hidden shadow-lg grid lg:grid-cols-6 grid-cols-2">
                {{--Estado de espera antes de mostrar la imagen--}}
                <div wire:loading class="relative lg:col-span-4 col-span-2 h-64 lg:h-auto lg:w-full w-full p-0 flex-none bg-cover bg-center rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" title="imagen publicada">
                    <p class="mt-32">Cargando...</p>
                </div>
                {{--Imagen--}}
                <div wire:loading.attr="hidden" class="relative lg:col-span-4 col-span-2 h-64 lg:h-auto lg:w-full w-full p-0 flex-none bg-cover bg-center rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('{{route('image.file', ['filename' => $images_detail['imgs']->image_path])}}')" title="imagen publicada">
                </div>
                <div class="lg:col-span-2 col-span-2">
                    <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                        <div class="flex items-center">
                            <img class="w-10 h-10 rounded-full mr-4" src="{{ $images_detail['imgs']->user->profile_photo_url }}" alt="">
                            <div class="text-sm">
                                <p class="text-gray-900 leading-none font-bold">{{ $images_detail['imgs']->user->name}}
                                    <span class="font-normal">
                                    {{ ' | @'.$images_detail['imgs']->user->nick }}
                                    </span>
                                </p>
                                <p class="text-gray-600">{{ \FormatTime::LongTimeFilter($images_detail['imgs']->created_at)}}</p>
                            </div>
                        </div>
                        <div class="">
                            <p class="mt-2">COMENTARIOS ({{ count($images_detail['imgs']->comments )}})</p>
                            <hr class="mb-2">
                            <!--Seccion de Comentarios-->
                            <div class="w-full h-64 overflow-y-scroll flow">
                                <div class="text-sm mb-2">
                                    <span class="font-bold">{{ '@'.$images_detail['imgs']->user->nick }}</span>{{' '.$images_detail['imgs']->description}}
                                </div>
                                @foreach($images_detail['imgs']->comments as $comment)
                                    <span class="font-bold text-sm">{{ '@'.$comment->user->nick }}</span>
                                    <p class="text-gray-600 text-sm">{{ \FormatTime::LongTimeFilter($comment->created_at)}}</p>
                                    <p class="text-sm"> {{ $comment->content }}</p>

                                    @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->images->user_id == Auth::user()->id))
                                        <a class="text-sm block ml-32 text-center text-gray-500 hover:font-bold" href="{{route('comment.delete', ['id' => $comment->id])}}">Eliminar</a>
                                    @endif
                                @endforeach
                            </div>
                            <hr>
                            <div class="flex">
                                {{count($images_detail['imgs']->likes)}}
                                <!--Comprobar si el usuario le dio like a la imagen-->
                                <?php  $user_like  = false ?>
                                @foreach($images_detail['imgs']->likes as $like)

                                    @if($like->user->id == Auth::user()->id)
                                        <?php  $user_like  = true ?>
                                    @endif
                                @endforeach
                                @if($user_like)
                                    <img class="flex-initial m-2 btn-dislike" data-id="{{$images_detail['imgs']->id}}" src="{{ asset('img/heart-red.png') }}">
                                @else
                                    <img class="flex-initial m-2 btn-like" data-id="{{$images_detail['imgs']->id}}" src="{{ asset('img/heart.png') }}">
                                @endif
                                <img class="flex-initial m-2" src="{{ asset('img/comment.png') }}">
                                @if ($btn && Auth::user() && Auth::user()->id == $images_detail['imgs']->user->id)
                                    <div class="flex">
                                        <button wire:click="edit({{$images_detail['imgs']->id}})" class="text-xs bg-transparent hover:bg-yellow-300 text-yellow-500 font-semibold hover:text-black my-2 mr-2 py-1 px-2 border border-yellow-500 hover:border-transparent rounded">ACTUALIZAR</button>
                                        <button wire:click="confirmPublicationDeletion" wire:loading.attr="disabled" class="text-xs bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white my-2 py-1 px-2 border border-red-500 hover:border-transparent rounded">BORRAR</button>
                                    </div>
                                @endif
                            </div>
                            <form action="/comment/save" method="post">
                                @csrf

                                <input type="hidden" name="image_id" value="{{$images_detail['imgs']->id}}">
                                <textarea class="{{ $errors->has('content') ? 'border-solid border-red-500' : ''}} resize-none border rounded focus:outline-none focus:shadow-outline mt-2 w-full" name="content" id="content" placeholder="Escribe un comntario..."></textarea>
                                @if($errors->has('content'))
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                        <strong class="font-bold">error!</strong>
                                        <span class="block sm:inline">{{ $errors->first('content') }}</span>
                                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                                        </span>
                                    </div>
                                @endif
                                <x-jet-button class="">
                                    {{ __('Comentar') }}
                                </x-jet-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingPublicationDeletion">
            <x-slot name="title">
                {{ __('Borrar publicación') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Esta seguro que desea borrar esta publicacion?') }}
                {{__('Una vez confirmado sera imposible volver atras.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingPublicationDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2"  wire:click="delete({{$images_detail['imgs']->id}})" wire:loading.attr="disabled">
                    {{ __('Borrar publicacion') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
</div>
