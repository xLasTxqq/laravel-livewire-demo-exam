<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $surname;
    public $patronymic;
    public $login;
    public $email;
    public $password;
    public $password_confirmation;
    public $rule;

    protected $rules = [
        'name' => 'required|string|max:255|regex:/^[ёА-я -]+$/ui',
        'surname' => 'required|string|max:255|regex:/^[ёА-я -]+$/ui',
        'patronymic' => 'nullable|string|max:255|regex:/^[ёА-я -]+$/ui',
        'login' => 'required|string|max:255|unique:users|regex:/^[A-z -]+$/ui',
        'email' => 'required|string|email:dns|max:255|unique:users',
        'password' => 'required|confirmed|min:6',
        'rule' => 'accepted'
    ];
    
    protected $validationAttributes = [
        'name'=>'имя',
        'surname'=>'фамилия',
        'patronymic'=>'отчество',
        'login'=>'логин',
        'email'=>'почта',
        'password'=>'пароль',
        'password_confiramtion'=>'подтверждение пароля',
        'rule'=>'согласие с правилами'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'login' => $this->patronymic,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole('user');

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function render()
    {
        return view('livewire.register')->layout('layouts/app');
    }
}
