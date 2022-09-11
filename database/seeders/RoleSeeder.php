<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'writer',
                'guard_name' => 'web'
            ]
        ];

        foreach ($roles as $item) {
            Role::create([
                'name' => $item['name'],
                'guard_name' => $item['guard_name']
            ]);
        }
    }
}
