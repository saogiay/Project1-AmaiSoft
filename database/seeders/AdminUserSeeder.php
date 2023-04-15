<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'admin',
                'email' => 'admin@localhost.com',
                'password' => bcrypt('123'),
            ], [
                'name' => 'Chuc',
                'email' => 'chuckinko@gmail.com',
                'password' => bcrypt('123'),
            ], [
                'name' => 'Tuan',
                'email' => 'tuanha@gmail.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'Cuong',
                'email' => 'cuong@gmail.com',
                'password' => bcrypt('123456'),
            ]
        ]);
    }
}
