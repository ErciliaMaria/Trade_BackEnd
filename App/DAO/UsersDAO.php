<?php

namespace App\DAO;

use App\Models\User;

class UsersDAO
{
     public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
     public function getUserById(int $id): ?User
    {
        return User::find($id); // Retorna null se não encontrar
    }
}
