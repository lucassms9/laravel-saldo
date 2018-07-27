<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Lucas Santos',
            'email' => 'lucassms9@hotmail.com',
            'password' => bcrypt('123456')

        ]);


        User::create([
            'name' => 'Outro User',
            'email' => 'joao@hotmail.com',
            'password' => bcrypt('123456')

        ]);

    }
}
