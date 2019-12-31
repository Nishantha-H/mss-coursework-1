<?php

use App\TimeSlot;
use Illuminate\Database\Seeder;

class TimeSlotsTableSeeder extends Seeder
{
    protected $slots = [
        ['start_at' => '14:00', 'end_at' => '14:30'],
        ['start_at' => '14:30', 'end_at' => '15:00'],
        ['start_at' => '15:00', 'end_at' => '15:30'],
        ['start_at' => '15:30', 'end_at' => '16:00'],
        ['start_at' => '16:00', 'end_at' => '16:30'],
        ['start_at' => '16:30', 'end_at' => '17:00'],
        ['start_at' => '17:00', 'end_at' => '17:30'],
        ['start_at' => '17:30', 'end_at' => '18:00'],
        ['start_at' => '18:00', 'end_at' => '18:30'],
        ['start_at' => '18:30', 'end_at' => '19:00'],
        ['start_at' => '19:00', 'end_at' => '19:30'],
        ['start_at' => '19:30', 'end_at' => '20:00'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->slots as $slot) {
            TimeSlot::create([
                'start_at' => $slot['start_at'],
                'end_at' => $slot['end_at'],
            ]);
        }
    }
}
