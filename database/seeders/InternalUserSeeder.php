<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InternalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'User Engineer',
                'email' => 'engineer@test.com',
                'password' => bcrypt('password'),
                'role' => 'engineer'
            ],
            [
                'name' => 'User Planner',
                'email' => 'planner@test.com',
                'password' => bcrypt('password'),
                'role' => 'planner'
            ],
            [
                'name' => 'User Supply Chain',
                'email' => 'sc@test.com',
                'password' => bcrypt('password'),
                'role' => 'supply_chain'
            ],
            [
                'name' => 'User Gudang',
                'email' => 'gudang@test.com',
                'password' => bcrypt('password'),
                'role' => 'gudang'
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
