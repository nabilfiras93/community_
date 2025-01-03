<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Categorie::insert([
            'title'  => 'News',
        ],[
            'title'  => 'Sport',
        ],);

        \App\Models\User::insert([
            'name'  => 'Admin',
            'email'  => 'admin@mail.com',
            'password'  => Hash::make('admin'),
        ]);
    }
    
}
