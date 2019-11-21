<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::insert([
            [
                'id' => 1,
                'name' => 'John Smith',
                'comments' => 'Director',
            ],[
                'id' => 2,
                'name' => 'Alane Sindhe',
                'comments' => 'Producer',
            ]
        ]);
    }
}
