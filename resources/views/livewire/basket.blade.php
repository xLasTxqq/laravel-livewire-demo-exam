<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Корзина') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div>
                    @if(empty($tickets->toArray()))
                    <h2 class="flex items-center justify-center font-bold text-3xl">Сеансов в корзине не найдено</h2>
                    @endif
                    @foreach($tickets as $ticket)
                    <div class="flex justify-start shadow items-center bg-gray-50 hover:bg-gray-100 m-6 rounded-md py-4 sm:mx-2 mx-0 px-4">
                        <div class="flex w-full justify-between flex-col items-center sm:flex-row">
                            <div class="flex sm:justify-start justify-center flex-col sm:flex-row">
                                <img class="aspect-square rounded-full sm:max-h-24 max-h-48 m-auto" src="{{sprintf('%s/storage/images/%s',route('about'),$ticket->session->image)}}">
                                <h2 class="font-semibold sm:text-2xl text-xl text-center flex items-center mx-6 my-4 justify-center">{{$ticket->session->name}}</h2>
                            </div>
                            @if (session()->has($ticket->id))
                            <div class="text-red-500">
                                {{ session($ticket->id) }}
                            </div>
                            @endif
                            <div class="flex flex-col justify-center">
                                <h2 class="font-semibold text-lg flex items-center justify-center">{{$ticket->session->price * $ticket->amount}} ₽</h2>
                                <div class="flex items-center justify-center">
                                    <x-button class="mx-2" wire:click="addTicket({{$ticket->id}})">+</x-button>
                                    <x-button class="mx-2" wire:click="deleteTicket({{$ticket->id}})">-</x-button>
                                </div>
                                <h2 class="font-semibold text-lg flex items-center justify-center">{{$ticket->amount}} шт.</h2>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if($tickets->count()>0)
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form wire:submit.prevent="saveOrder" class="sm:w-2/3 md:w-1/2 w-full justify-center m-auto">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <div class="my-4">
                        <x-label for="password" :value="__('Пароль *')" />

                        <x-input wire:model.lazy="password" id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="current-password" />
                    </div>
                    <x-button>Сформировать заказ</x-button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>