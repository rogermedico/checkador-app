<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::create([
            'user_id' => 1,
            'event_type_id' => 1,
            'date' => Carbon::createFromDate(2022, 1, 8),
            'time' => Carbon::createFromTime(8, 0),
        ]);

        Event::create([
            'user_id' => 1,
            'event_type_id' => 2,
            'date' => Carbon::createFromDate(2022, 1, 8),
            'time' => Carbon::createFromTime(12, 34),
        ]);

        Event::create([
            'user_id' => 1,
            'event_type_id' => 1,
            'date' => Carbon::createFromDate(2022, 1, 8),
            'time' => Carbon::createFromTime(14, 0),
        ]);

        Event::create([
            'user_id' => 1,
            'event_type_id' => 2,
            'date' => Carbon::createFromDate(2022, 1, 8),
            'time' => Carbon::createFromTime(17, 22),
        ]);

        Event::create([
            'user_id' => 1,
            'event_type_id' => 1,
            'date' => Carbon::createFromDate(2022, 1, 9),
            'time' => Carbon::createFromTime(8, 0),
        ]);

        Event::create([
            'user_id' => 1,
            'event_type_id' => 2,
            'date' => Carbon::createFromDate(2022, 1, 9),
            'time' => Carbon::createFromTime(18, 0),
        ]);
    }
}
