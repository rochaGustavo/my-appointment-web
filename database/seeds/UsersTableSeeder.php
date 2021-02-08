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
            'name' => 'admin',
            'email' => 'admin@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'patient test',
            'email' => 'patient@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('patient'),
            'role' => 'patient'
        ]);
        User::create([
            'name' => 'doctor test',
            'email' => 'doctor@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('doctor'),
            'role' => 'doctor'
        ]);
        factory(User::class ,50)->states('patient')->create();
    }
}
