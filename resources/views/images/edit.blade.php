<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Larafoto
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        <div class="grid grid-cols-1 gap-4">
            <div class="col-span-1 bg-white shadow py-10 px-10">
                <form action="/image/update" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
                        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
                            <div class="absolute inset-0 bg-gradient-to-r from-teal-400 to-blue-400 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
                            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                                <div class="max-w-md mx-auto">
                                    <div>
                                        <div class="h-36 w-36 my-5 ml-32 p-0 flex-none bg-cover bg-center rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('{{route('image.file', ['filename' => $image->image_path])}}')" title="imagen publicada">
                                        </div>
                                    </div>
                                    <div class="divide-y divide-gray-200">
                                        <input type="hidden" name="image_id" value="{{$image->id}}">
                                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                            <!-- Profile Photo File Input -->
                                            <x-jet-label for="image_path" value="{{ __('Imagen') }}" />
                                            <input type="file" name="image_path" id="image_path" class="mt-1">
                                            <x-jet-input-error for="image_path" class="mt-2" />

                                            <x-jet-label for="description" value="{{ __('Description') }}" />
                                            <textarea id="description" name="description" type="text" class="border-solid border-2 border-gray-300 mt-1 block w-full" wire:model.defer="state.description">{{$image->description}}</textarea>
                                            <x-jet-input-error for="description" class="mt-2" />
                                        </div>
                                        <div class="pt-6 text-base leading-6 font-bold sm:text-lg sm:leading-7">
                                            <x-jet-button class="ml-4">
                                                {{ __('Actualizar imagen') }}
                                            </x-jet-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>