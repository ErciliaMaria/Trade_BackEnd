<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'email',
        'balance',
        'password',
    ];


    public $timestamps = false;

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

       public function stocks()
    {
        return $this->belongsToMany(Stock::class, 'trades', 'user_id', 'stock_id')
            ->withPivot(['quantity', 'type']); // Pega também a quantidade e tipo
    }
}
