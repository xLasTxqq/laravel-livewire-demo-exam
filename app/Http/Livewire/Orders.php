<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Orders extends Component 
{
    public function deleteOrder(Order $order)
    {
        if($order->user_id==Auth::user()->id && $order->status_id==1){
            $order->delete();
        }
    }
    public function render()
    {
        return view('livewire.orders',[
            'orders'=>Order::where('user_id',Auth::user()->id)->orderByDesc('created_at')->get()
        ])->layout('layouts/app');
    }
}
