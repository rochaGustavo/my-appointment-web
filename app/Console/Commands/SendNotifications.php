<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Appointment;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar mensajes via FCM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Buscando citas medicas:");

        $now = Carbon::now();

        $headers =['id','scheduled_date','scheduled_time','patient_id'];

        $appointmentsTomorrow = $this->getAppointments24Hours($now->copy());
        $this->table($headers, $appointmentsTomorrow->toArray());
        
       // dd($appointments);
    
        foreach($appointmentsTomorrow as $appointment){
             $appointment->patient->sendFCM('No olvides tu cita mañana a esta hora.');
             $this->info('Mensaje FCM enviado 24h antes  al paciente (ID): ' . $appointment->patient_id);
        }
        

        $appointmentsNextHour = $this->getNextHour($now->copy());
        $this->table($headers, $appointmentsNextHour->toArray());

        foreach($appointmentsNextHour as $appointment){
            $appointment->patient()->sendFCM('Tienes cita en 1 hora. Te esperamos.');
            $this->info('Mensaje FCM enviado faltando 1h  al paciente (ID): ' . $appointment->patient_id);
        }
       

    }

    private function getAppointments24Hours($now){

        return Appointment::Where('status','Confirmada')
        ->Where('scheduled_date' ,$now->addDay()->toDateString())
        ->Where('scheduled_time', '>=' ,$now->copy()->subMinutes(3)->toTimeString())
        ->Where('scheduled_time', '<' ,$now->copy()->addMinutes(2)->toTimeString())
        ->get(['id','scheduled_date','scheduled_time','patient_id']);
    } 

    private function getNextHour($now){
        return Appointment::Where('status','Confirmada')
        ->Where('scheduled_date' ,$now->addHour()->toDateString())
        ->Where('scheduled_time', '>=' ,$now->copy()->subMinutes(3)->toTimeString())
        ->Where('scheduled_time', '<' ,$now->copy()->addMinutes(2)->toTimeString())
        ->get(['id','scheduled_date','scheduled_time','patient_id']);
    }
}
