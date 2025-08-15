<?php
namespace App\Request;

use Illuminate\Validation\Factory;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;

class TradeRequest
{
    public function validate(array $data): array
    {
        $translator = new Translator(new ArrayLoader(), 'en');
        $factory = new Factory($translator);

        return $factory->make($data, [
            'user_id'  => 'required|integer|min:1',
            'stock_id' => 'required|integer|min:1',
            'type'     => 'required|string|in:buy,sell',
            'quantity' => 'required|integer|min:1',
            'price' => 'required'
        ])->errors()->all();
    }
}
