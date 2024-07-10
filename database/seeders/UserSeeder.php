<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = "andreygoncalvesdev@gail.com";

        if(!User::where("email", $email)->exists())
        {
            User::create([
                'name' => 'Andrey',
                'email'=> 'andreygoncalvesdev@gmail.com',
                'password'=> Hash::make('v0l4i', ['rounds' => 12])
            ]);
        }
    }
}
