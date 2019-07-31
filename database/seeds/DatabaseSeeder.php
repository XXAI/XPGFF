<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'username' => 'admin',
            'password' => Hash::make('ssa.fuentes.2019.finan')
        ]);
    }
}
