<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Афиша') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex lg:flex-row flex-col justify-between items-center">
                    <div class="flex sm:flex-row flex-col items-center justify-between w-full sm:mx-4 mx-0">
                        <h2 class="flex items-center font-bold text-xl py-8 sm:px-4 px-0">Упорядочить:</h2>

                        <div class="flex justify-between items-center">
                            <x-dropdown-link class="rounded-full cursor-pointer text-center max-w-[30%] flex flex-col items-center justify-center py-2" wire:click="show_date">Дата показа<span>{{is_null($show_date)?'':($show_date?'ᐁ':'ᐃ')}}</span></x-dropdown-link>
                            <x-dropdown-link class="rounded-full cursor-pointer text-center max-w-[30%] flex flex-col items-center justify-center py-2" wire:click="name">Название<span>{{is_null($name)?'':($name?'ᐁ':'ᐃ')}}</span></x-dropdown-link>
                            <x-dropdown-link class="rounded-full cursor-pointer text-center max-w-[30%] flex flex-col items-center justify-center py-2" wire:click="age">Возростное ограничение<span>{{is_null($age)?'':($age?'ᐁ':'ᐃ')}}</span></x-dropdown-link>
                        </div>
                    </div>
                    <div class="flex sm:flex-row flex-col items-center justify-between w-full sm:mx-4 mx-0">
                        <h2 class="flex items-center font-bold text-xl py-8 sm:px-4 px-0">Отфильтровать по жанру:</h2>

                        <select wire:model="genre">
                            <option value="" selected>Все жанры</option>
                            @foreach($genres as $genre)
                            <option value="{{$genre->id}}">{{$genre->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-6">
            <div class="p-6 bg-white border-b border-gray-200 xl:grid-cols-3 grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 grid">
                @if(empty($sessions->toArray()))
                <h2 class="flex items-center justify-center font-bold text-3xl">Сеансов не найдено</h2> 
                @endif
                @foreach($sessions as $session)
                <div class="flex flex-col justify-between shadow items-center bg-gray-50 hover:bg-gray-100 m-6 rounded-md py-4 sm:mx-2 mx-0">
                    <a href="{{route('session',$session->id)}}" class="w-full flex flex-col items-center mb-2">
                    <!-- break-all  -->
                        <h2 class="font-semibold text-2xl text-center">{{$session->name}}</h2>
                        <img class="aspect-video rounded-md mt-2 w-4/5" src="{{sprintf('%s/storage/images/%s',route('about'),$session->image)}}">
                    </a>
                    <div class="flex w-4/5 {{Auth::check()?'justify-between':'justify-center'}}">
                        @auth
                        <x-button wire:click="addToBasket({{$session->id}})" class="mr-4">
                            @if(Auth::user()->tickets->where('session_id',$session->id)->where('order_id',null)->count()>0)
                            В корзине {{Auth::user()->tickets->where('session_id',$session->id)->where('order_id',null)->first()->amount}}шт.
                            @else
                            В корзину
                            @endif
                        </x-button>
                        @endauth
                        <h2 class="font-semibold text-lg">от {{$session->price}} ₽</h2>
                    </div>
                    @if (session()->has($session->id))
                    <div class="text-red-500">
                        {{ session($session->id) }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>