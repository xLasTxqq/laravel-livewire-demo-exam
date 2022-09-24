<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function genres()
    {
        return $this->belongsTo(Genre::class,'genre_id','id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'session_id','id');
    }
}
