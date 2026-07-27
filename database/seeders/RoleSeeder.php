<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    Role::create([
        'nama' => 'admin'
    ]);

    Role::create([
        'nama' => 'kasir'
    ]);
}
}
