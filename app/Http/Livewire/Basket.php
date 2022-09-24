<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Basket extends Component
{

    public $password;


    public function saveOrder()
    {
        $tickets = Auth::user()->tickets->where('order_id',null);

        foreach($tickets as $ticket){
            $count = $ticket->session->amount-($ticket->session->tickets->where('order_id','!=',null)->sum('amount'));
            if(($count-$ticket->amount)<0){
            session()->flash($ticket->id, sprintf('На данный сеанс доступно %d билетов',$count));
            throw ValidationException::withMessages([
                'password' => sprintf('На сеанс %s доступно билетов %d, пожалуйста уберите лишние билеты!',$ticket->session->name,$count),
            ]);
            }
        }

        $this->validate([
            'password'=>'required'
        ],[],['password'=>'пароль']);

        if (! Auth::guard('web')->validate([
            'login' => Auth::user()->login,
            'password' => $this->password,
        ])) {
            $this->reset();
            throw ValidationException::withMessages([
                'password' => __('Пароль не совпадает с вашим паролем'),
            ]);
        }

        $order = Order::create([
            'status_id'=>1,
            'user_id'=>Auth::user()->id
        ]);

        foreach($tickets as $ticket){
            $ticket->order_id = $order->id;
            $ticket->save();
        }

        $this->reset();

    }

    public function updated($input)
    {
        $this->validateOnly($input,[
            'password'=>'required'
        ],[],['password'=>'пароль']);
    }

    public function deleteTicket(Ticket $ticket)
    {
        if ($ticket->user_id == Auth::user()->id && $ticket->order_id == null) {
            if ($ticket->amount < 2) $ticket->delete();
            else {
                $ticket->amount -= 1;
                $ticket->save();
            }
        }
    }

    public function addTicket(Ticket $ticket)
    {
        if ($ticket->user_id == Auth::user()->id && $ticket->order_id == null) {
            if (!($ticket->session->amount > ($ticket->session->tickets->where('order_id', '!=', null)->sum('amount') + (!empty($ticket) ? $ticket->amount : 0)))) session()->flash($ticket->id, 'На данный сеанс больше билетов нет');
            else $ticket->amount += 1;
            $ticket->save();
        }
    }

    public function render()
    {
        $userTickets = Auth::user()->tickets->where('order_id', null);
        return view('livewire.basket', [
            'tickets' => $userTickets
        ])->layout('layouts/app');
    }
}
