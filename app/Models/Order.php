<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'order_id','id'); 
    }

    public function status()
    {
        return $this->belongsTo(Status::class,'status_id','id'); 
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
