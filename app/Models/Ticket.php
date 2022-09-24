<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function session()
    {
        return $this->belongsTo(Session::class,'session_id','id');
    }
    // public function status()
    // {
    //     return $this->belongsTo(Status::class,'status_id','id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
