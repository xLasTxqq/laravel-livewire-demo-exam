<?php

namespace App\Http\Livewire;

use App\Models\Session;
use Livewire\Component;

class About extends Component
{
    public function render()
    {
        $sessions = Session::orderByDesc('created_at')->limit(5)->get();
        return view('livewire.about',['sessions'=>$sessions])->layout('layouts/app');
    }
}
