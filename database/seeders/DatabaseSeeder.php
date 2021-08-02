<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Company\Models\Company;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Company::query()->create(
            [
                'name' => 'Test Company',
            ]
        );
    }
}
