<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        $roles['user'] = Role::create(['name' => 'User']);
        $roles['super-admin'] = Role::create(['name' => 'SuperAdmin']);
        $roles['admin'] = Role::create(['name' => 'admin']);
        Schema::enableForeignKeyConstraints();
    }
}
