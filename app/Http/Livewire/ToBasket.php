<?php

namespace App\Http\Livewire;

use App\Models\Session;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

trait ToBasket
{
    public function addToBasket(Session $session)
    {
        // dd(!($session->amount>=$session->tickets->sum('amount')));
        if (Auth::check()) {
            $ticket = Ticket::where(['session_id'=>$session->id,'user_id'=>Auth::user()->id,'order_id'=>null])->first();

            if(!($session->amount>($session->tickets->where('order_id','!=',null)->sum('amount')+(!empty($ticket)?$ticket->amount:0)))) {
                session()->flash($session->id, 'На данный сеанс закончились билеты');
                return;
            }
            if (!empty($ticket)) {
                $ticket->amount += 1;
                $ticket->save();
            } else {
                Ticket::create([
                    'session_id' => $session->id,
                    'user_id' => Auth::user()->id,
                    // 'status_id' => 4,
                    'amount' => 1
                ]);
            }
        }
    }
}
