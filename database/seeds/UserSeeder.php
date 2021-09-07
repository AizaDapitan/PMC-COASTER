<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ray',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}
