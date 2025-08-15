<?php
namespace App\Request;

use Illuminate\Validation\Factory;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;

class LoginRequest
{
    public function validate(array $data): array
    {
        $translator = new Translator(new ArrayLoader(), 'en');
        $factory = new Factory($translator);

        return $factory->make($data, [
            'email'    => 'required|email',
            'password' => 'required|string|min:8',
            'balance' => 'numeric|min:0'
        ])->errors()->all();
    }
}
