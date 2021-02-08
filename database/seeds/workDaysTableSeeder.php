<?php

use Illuminate\Database\Seeder;
use App\workday;

class workDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<7; $i++){

            workday::create([
                'day' => $i,
                'active' => ($i==3), //thursday
                'morning_start' => ($i==3 ? '07:00:00' : '01:00:00'),
                'morning_end' => ($i==3 ? '09:30:00' : '01:00:00'),
                'afternoon_start' => ($i==3 ? '15:00:00' : '13:00:00'),
                'afternoon_end' => ($i==3 ? '18:00:00': '13:00:00'),
                'user_id' => 3 //Medico Test (UserTableSeeder)
            ]);
        }
    }
}
