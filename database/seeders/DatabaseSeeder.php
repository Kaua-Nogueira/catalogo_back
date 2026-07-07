<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $company = \App\Models\Company::create([
            'name' => 'Nimbus Store',
            'slug' => 'nimbus-store',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'admin@nimbus.com',
            'password' => bcrypt('password'),
            'company_id' => $company->id,
            'role' => 'admin',
        ]);
    }
}
