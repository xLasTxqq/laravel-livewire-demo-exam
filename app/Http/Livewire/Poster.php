<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Session;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Poster extends Component
{
    use ToBasket;

    public $genre;

    public $show_date;
    public $name;
    public $age;

    public function show_date()
    {
        if (empty($this->show_date))
            $this->reset('name', 'age', 'show_date');
        $this->show_date = !$this->show_date;
    }
    public function name()
    {
        if (empty($this->name))
            $this->reset('name', 'age', 'show_date');
        $this->name = !$this->name;
    }
    public function age()
    {
        if (empty($this->age))
            $this->reset('name', 'age', 'show_date');
        $this->age = !$this->age;
    }

    public function render()
    {
        $sessions = Session::where('show_date', '>', now());
        if (!is_null($this->show_date))
            $sessions = $sessions->orderBy('show_date', $this->show_date ? 'desc' : 'asc');

        else if (!is_null($this->name)) {
            $sessions = $sessions->orderBy('name', $this->name ? 'desc' : 'asc');
        } else if (!is_null($this->age))
            $sessions = $sessions->orderBy('age', $this->age ? 'desc' : 'asc');
        else $sessions = $sessions->orderByDesc('created_at');

        if (!empty($this->genre))
            $sessions = $sessions->where('genres_id', $this->genre);

        return view('livewire.poster', [
            'sessions' => $sessions->get(),
            'genres' => Genre::all()
        ])->layout('layouts/app');
    }
}
