<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Заказы') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid gap-4">
                    @foreach($orders as $order)
                    <div class="bg-gray-300/40 rounded-lg p-4 shadow">
                        <h2 class="font-bold text-2xl">{{$order->status->name}} заказ</h2>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 grid-cols-1 gap-4 my-4">
                        @foreach($order->tickets as $ticket)
                        <div class="bg-white shadow rounded-lg py-2 px-4 flex flex-col">
                        <h2 class="text-lg">{{$ticket->session->name}}</h2>
                        <h2 class="text-lg">{{$ticket->amount}} шт.</h2>                       
                        </div>
                        @endforeach
                        </div>
                        @if($order->status_id==1)
                        <x-button wire:click="deleteOrder({{$order->id}})">Удалить</x-button>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>