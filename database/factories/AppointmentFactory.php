<?php

use Faker\Generator as Faker;

use App\Appointment;
use App\User;

$factory->define(App\Appointment::class, function (Faker $faker) {
    
    $doctorIds = User::doctors()->pluck('id');
    $patientIds = User::patients()->pluck('id');
    $date = $faker->datetimeBetween('-1year', 'now');
    $scheduled_date = $date->format('Y-m-d');
    $scheduled_time = $date->format('H:i:s');

    $types = ['consulta', 'Examen', 'Operación'];
    $status = ['Atendida', 'Cancelada'];

    return [
          'description'  =>$faker->sentence(5),
          'specialty_id' => $faker->numberBetween(1,3),
          'doctor_id'    => $faker->randomElement($doctorIds),
          'patient_id'   => $faker->randomElement($patientIds),
          'scheduled_date' => $scheduled_date,
          'scheduled_time' => $scheduled_time,
          'type' =>  $faker->randomElement($types),
          'status' => $faker->randomelement($status)
    ];
});
