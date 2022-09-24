<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Order;
use App\Models\Session;
use App\Models\Status;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class Admin extends Component
{
    use WithFileUploads;

    //Поля для заказов
    public $status;
    public $changeableOrders;

    //Поле для создания жанра
    public $genre_name;

    //Поля для создания сеансов
    public $session_name;
    public $session_age;
    public $session_image;
    public $session_price;
    public $session_genres_id;
    public $session_show_date;
    public $session_amount;

    //Поля для изменения сеансов
    public $sessions;
    public $files;

    protected $rules = [
        'session_name' => 'required|string|max:255',
        'session_age' => 'required|numeric|integer|max:100|min:0',
        'session_image' => 'required|image|mimes:png,jpg,jpeg,bmp|max:10240',
        'session_price' => 'required|min:0|numeric',
        'session_genres_id' => 'required|numeric|exists:genres,id',
        'session_show_date' => 'required|date',
        'session_amount' => 'required|numeric|integer|min:0',
        'genre_name' => 'required|string|max:255'
    ];

    protected $validationAttributes = [
        'session_name' => 'название сеанса',
        'session_age' => 'возростное ограничение',
        'session_image' => 'картинка',
        'session_price' => 'цена',
        'session_genres_id' => 'жанр',
        'session_show_date' => 'дата показа',
        'session_amount' => 'количество билетов',
        'genre_name' => 'название жанра'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function changeStatus(Order $order)
    {
        $validated = $this->validate([
            'changeableOrders.'.$order->id.'.status'=>'required|string|exists:statuses,id',
            'changeableOrders.'.$order->id.'.cause'=>sprintf('exclude_unless:%s,3|required|string','changeableOrders.'.$order->id.'.status')
        ],[],[
            'changeableOrders.'.$order->id.'.status'=>'статус',
            'changeableOrders.'.$order->id.'.cause'=>'причина'
        ]);
        if($order->status_id == 1){
            $order->status_id = $validated['changeableOrders'][$order->id]['status'];
            $order->cause = $validated['changeableOrders'][$order->id]['cause']??null;
            $order->save();
        }        
    }

    public function createGenre()
    {
        $this->validate(collect($this->rules)->only(['genre_name'])->toArray());
        Genre::create([
            'name' => $this->genre_name
        ]);
        $this->genre_name = '';
        session()->flash('createdGenre', 'Жанр создан');
    }

    public function deleteGenre($id)
    {
        $sessions = Session::where('genres_id', $id)->get();
        $images = [];
        foreach ($sessions as $session) {
            if (!empty($session->image)) $images[] = sprintf("public/images/%s", $session->image);
        }
        Storage::delete($images);
        Genre::where('id', $id)->delete();
    }

    public function createSession()
    {
        $this->validate(collect($this->rules)->except(['genre_name'])->toArray());

        $nameImage = sprintf("%s.%s", str()->random(16), $this->session_image->extension());
        $this->session_image->storePubliclyAs('images', $nameImage, 'public');
        Session::create([
            'name' => $this->session_name,
            'age' => $this->session_age,
            'image' => $nameImage,
            'price' => $this->session_price,
            'genres_id' => $this->session_genres_id,
            'show_date' => $this->session_show_date,
            'amount' => $this->session_amount
        ]);


        $this->sessions = Session::all()->toArray();
        foreach($this->sessions as $i=>$session)
        {
            $this->sessions[$i]['show_date']=Carbon::parse($session['show_date'])->isoFormat('Y-MM-DDThh:mm');
        }

        $this->session_name=null;
        $this->session_age=null;
        $this->session_image=null;
        $this->session_price=null;
        $this->session_genres_id=null;
        $this->session_show_date=null;
        $this->session_amount=null;
        session()->flash('createdSession', 'Сеанс создан');
    }

    public function deleteSession(Session $session)
    {
        if (!empty($session->image))
            Storage::delete(sprintf("public/images/%s", $session->image));
        $session->delete();

        $this->sessions = Session::all()->toArray();
        foreach($this->sessions as $i=>$session)
        {
            $this->sessions[$i]['show_date']=Carbon::parse($session['show_date'])->isoFormat('Y-MM-DDThh:mm');
        }
    }

    public function updateSession(Session $session)
    {
        $sessionUpdate = collect($this->sessions)->where('id',$session->id);
        $validated = $this->validate([
            'sessions.'.$sessionUpdate->keys()[0].'.name'=>'required|string|max:255',
            'sessions.'.$sessionUpdate->keys()[0].'.age'=>'required|numeric|integer|max:100|min:0',
            'sessions.'.$sessionUpdate->keys()[0].'.price'=>'required|min:0|numeric',
            'sessions.'.$sessionUpdate->keys()[0].'.genres_id'=>'required|numeric|exists:genres,id',
            'sessions.'.$sessionUpdate->keys()[0].'.show_date'=>'required|date',
            'sessions.'.$sessionUpdate->keys()[0].'.amount'=>'required|numeric|integer|min:0',
            'files.'.$session->id=>'image|mimes:png,jpg,jpeg,bmp|max:10240',
        ],[],[
            'sessions.'.$sessionUpdate->keys()[0].'.name'=>'название сеанса',
            'sessions.'.$sessionUpdate->keys()[0].'.age'=>'возростное ограничение',
            'sessions.'.$sessionUpdate->keys()[0].'.price'=>'цена',
            'sessions.'.$sessionUpdate->keys()[0].'.genres_id'=>'жанр',
            'sessions.'.$sessionUpdate->keys()[0].'.show_date'=>'дата показа',
            'sessions.'.$sessionUpdate->keys()[0].'.amount'=>'количество билетов',
            'files.'.$session->id=>'картинка',
        ]);
        
        if(!empty($validated['files'][$session->id])){
            $file = $validated['files'][$session->id];
            Storage::delete($session->image);

            $nameImage = sprintf("%s.%s", str()->random(16), $file->extension());
            $file->storePubliclyAs('images', $nameImage, 'public');

            $validated['sessions'][$sessionUpdate->keys()[0]]['image']=$nameImage;
        }

        $validated = $validated['sessions'][$sessionUpdate->keys()[0]];

        Session::where('id',$session->id)->update(
            $validated
        );
        session()->flash($session->id, 'Сеанс обновлен');
    }

    public function mount(){
        $this->sessions = Session::all()->toArray();
        foreach($this->sessions as $i=>$session)
        {
            $this->sessions[$i]['show_date']=Carbon::parse($session['show_date'])->isoFormat('Y-MM-DDThh:mm');
        }
    }

    public function render()
    {

        $orders = Order::orderByDesc('created_at');
        if (!is_null($this->status) && is_numeric($this->status))
            $orders = $orders->where('status_id', $this->status);
        return view('livewire.admin', [
            'statuses' => Status::all(),
            'orders' => $orders->get(),
            'genres' => Genre::all(),
            'sessions_db' => Session::all(),
        ]);
    }
}
