<div class="grid grid-cols-6 gap-4">
    <div class="col-span-6 mx-5 sm:col-start-2 sm:col-span-3">
        <!--Maquetacion card-->
        <div class="rounded overflow-hidden shadow-lg my-10 mx-0">
            <div class="flex items-center">
                <img src="{{ $image->user->profile_photo_url }}" class="rounded-full h-16 w-16 flex items-center justify-center" alt="">
                <div class="text-sm pl-2">
                    <a class="text-blue-700 hover:underline" href="{{ route('user.profile', ['id'=> $image->user->id]) }}">
                        <p class="leading-none font-bold">{{ $image->user->name}}
                            <span class="font-normal">
                            {{ ' | @'.$image->user->nick }}
                            </span>
                        </p>
                    </a>
                    <p class="text-gray-600">{{ \FormatTime::LongTimeFilter($image->created_at)}}</p>
                </div>
            </div>
            <img class="w-full" src="{{route('image.file', ['filename' => $image->image_path])}}" alt="Sunset in the mountains">
            <div class="px-6 py-4">
                <div class="flex">
                    {{count($image->likes)}}
                    <!--Comprobar si el usuario le dio like a la imagen-->
                    <?php  $user_like  = false ?>
                    @foreach($image->likes as $like)

                        @if($like->user->id == Auth::user()->id)
                            <?php  $user_like  = true ?>
                        @endif
                    @endforeach
                    @if($user_like)
                        <img class="flex-initial m-2 btn-dislike" data-id="{{$image->id}}" src="{{ asset('img/heart-red.png') }}">
                    @else
                        <img class="flex-initial m-2 btn-like" data-id="{{$image->id}}" src="{{ asset('img/heart.png') }}">
                    @endif
                    <a href="{{ route('image.detail', ['id' => $image->id]) }}">
                        <img class="flex-initial m-2" src="{{ asset('img/comment.png') }}">
                    </a>
                </div>
                <div class="text-xl mb-2">
                    <span class="font-bold">{{ '@'.$image->user->nick }}</span>{{' '.$image->description}}
                </div>

                <p>COMENTARIOS ({{ count($image->comments )}})</p>
            </div>
        </div>
    </div>
</div>