<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
        User::factory()->create([
            'name' => 'Roger',
            'surname' => 'Medico Piqué',
            'email' => 'admin@gmail.com',
            'hired' => Carbon::createFromDate(2022, 1, 4),
            'holidays' => 22,
            'personal_business_days' => 3,
            'admin' => true,
        ]);

        User::factory()->create([
            'email' => 'user@gmail.com',
        ]);
    }
}
