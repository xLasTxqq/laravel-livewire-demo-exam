<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Сеанс') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="items-center flex flex-col justify-center">
                    <h2 class="font-bold text-3xl sm:text-5xl">{{$session->name}}</h2> 
                    <img class="aspect-video rounded-xl w-full sm:w-4/5 w-9/10 mt-6 mb-2 mx-4" src="{{sprintf('%s/storage/images/%s',route('about'),$session->image)}}">
                    <!-- <div class="flex justify-between sm:w-4/5 w-9/10 items-start flex-row"> -->
                    <div class="sm:w-4/5 w-9/10 flex items-center justify-between sm:flex-row flex-col">
                        <h2 class="font-semibold text-md mb-2">Дата сеанса - {{Carbon\Carbon::parse($session->show_date)->isoFormat('LLL')}}</h2>
                        <h2 class="font-semibold text-md text-orange-700 mb-2">Возрастное ограничение: {{$session->age}}+</h2>
                    </div>
                    <div class="flex sm:w-4/5 w-9/10 items-center">
                        @auth
                        <x-button wire:click="addToBasket({{$session->id}})" class="mr-4">
                        @if(Auth::user()->tickets->where('session_id',$session->id)->where('order_id',null)->count()>0)
                            В корзине {{Auth::user()->tickets->where('session_id',$session->id)->where('order_id',null)->first()->amount}}шт.
                            @else
                            В корзину
                            @endif
                        </x-button>
                        @endauth
                        <h2 class="font-bold text-lg">{{$session->price}} ₽</h2>
                    </div>
                    @if (session()->has($session->id))
                    <div class="text-red-500">
                        {{ session($session->id) }}
                    </div>
                    @endif
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>