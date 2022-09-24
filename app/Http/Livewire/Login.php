<?php

namespace App\Http\Livewire;

use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public $login;
    public $password;
    public $remember;

    protected function rules(){
        return (new LoginRequest)->rules();
    }

    protected function validationAttributes(){
        return (new LoginRequest)->attributes();
    }

    public function login(){

        $this->validate();

        $request = new LoginRequest($this->all()); 

        $request->authenticate();

        // $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
        
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.login')->layout('layouts/app');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
