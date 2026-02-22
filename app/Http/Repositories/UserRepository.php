<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    public function create(array $data): User 
    {
        return User::create([
            'name' => $data['name'],
            'father_lastname' => $data['father_lastname'],
            'mother_lastname' => $data['mother_lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'points' => 0,
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByUserName(string $username): ?User
    {
        return User::where('username', $username)->first();
    }
}
