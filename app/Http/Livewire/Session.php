<?php

namespace App\Http\Livewire;

use App\Models\Session as ModelSession;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Session extends Component
{
    use ToBasket;

    public ModelSession $session;

    public function mount($id){
        $this->session = ModelSession::where('id',$id)->first();
    }

    public function render() 
    {   
        return view('livewire.session')->layout('layouts/app'); 
    }
}
