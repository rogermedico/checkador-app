<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventType::create([
            'name' => 'in',
        ]);

        EventType::create([
            'name' => 'out',
        ]);

        EventType::create([
            'name' => 'holiday',
        ]);

        EventType::create([
            'name' => 'personal business',
        ]);
    }
}
