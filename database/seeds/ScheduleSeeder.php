<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monday = Carbon::now()->startOfWeek()->add(7, 'days');
        $saturday = Carbon::now()->startOfWeek()->add(5, 'days');
        $mondayString = $monday->isoFormat('dddd');
        $saturdayString = $saturday->isoFormat('dddd');

        DB::table('schedules')->insert([
            'travel_date' => $saturday->format('Y-m-d'),
            'travel_day' => $saturdayString,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('schedules')->insert([
            'travel_date' => $monday->format('Y-m-d'),
            'travel_day' => $mondayString,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
