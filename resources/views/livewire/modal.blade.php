<div>
    {{--abre un diseño modal--}}
    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center" style="background-color: rgba(0,0,0,.5);" x-show="open">
        <div class="text-left bg-white h-auto  md:max-w-full sm:w-2/3 w-full shadow-xl rounded mx-2 mt:32 lg:mt-0 sm:mt-64 md:mx-0" @click.away="open = false">
            {{--Integro el componente modal horizontal para detalles--}}
                @livewire('card-horizontal',['image' => ''])
        </div>
      </div>
</div>
