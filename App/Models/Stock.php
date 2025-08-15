<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'symbol', 
        'name', 
        'price'
    ];

    public function stock()
    {
        return $this->hasMany(Trade::class);
    }

     public function users()
    {
        return $this->belongsToMany(User::class, 'trades', 'stock_id', 'user_id')
            ->withPivot(['quantity', 'type']);
    }
}
