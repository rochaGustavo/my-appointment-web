<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Specialty;

use App\Appointment;

use App\CancelledAppointment;
use App\Interfaces\ScheduleServiceInterface;
use App\Http\Requests\StoreAppointment;

use Carbon\Carbon;

use Validator;
class AppointmentController extends Controller
{   
    public function index()
    {

        $role= auth()->user()->role;
        if($role == 'admin')
        {
            $pendingAppointments = Appointment::where('status', 'Reservada')  
            ->paginate(10);
            $confirmedAppointments =  Appointment::where('status', 'Confirmada')     
            ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida','Cancelado'])    
            ->paginate(10); 

        }elseif($role == 'doctor')
        {
            $pendingAppointments = Appointment::where('status', 'Reservada')
            ->where('doctor_id', auth()->id())    
            ->paginate(10);
            $confirmedAppointments =  Appointment::where('status', 'Confirmada')
                ->where('doctor_id', auth()->id())    
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida','Cancelado'])
                ->where('doctor_id', auth()->id())    
                ->paginate(10); 

        } elseif($role == 'patient') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
            ->where('patient_id', auth()->id())    
            ->paginate(10);
            $confirmedAppointments =  Appointment::where('status', 'Confirmada')
                ->where('patient_id', auth()->id())    
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida','Cancelado'])
                ->where('patient_id', auth()->id())    
                ->paginate(10);
        }

       
        return view('appointments.index', compact('pendingAppointments', 'confirmedAppointments', 'oldAppointments','role'));
        
    }

    public function show(Appointment $appointment)
    {
        $role = auth()->user()->role;
         return view('appointments.show', compact('appointment', 'role'));
    }
    

    public function create (ScheduleServiceInterface $sheduleService)
    {
        $specialties = Specialty::all();
        //dd($specialties->toArray());
        $specialtyId = old('specialty_id');
        if($specialtyId){
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        } else {
            $doctors = collect();
        }
        
        $scheduleDate = old('scheduled_date');
        $doctorId = old('doctor_id');
        if($scheduleDate && $doctorId){

            $intervals = $sheduleService->getAvailableIntervals($scheduleDate, $doctorId);
        } else{
            $intervals= null;
            }
       

        return view('appointments.create', compact('specialties', 'doctors','intervals'));
    }

    public function store(StoreAppointment $request) 
    {
        /*
        $rules = [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id' => 'exists:users,id',
            'scheduled_time' => 'required'
        ];
        $messages = [
           'scheduled_time.required' => 'Por favor seleccione una hora valida para su cita.' 
        ]; 
         $validator = Validator::make($request->all(), $rules, $messages); 

         $validator->after(function($validator) use ($request, $scheduleService){
             $date = $request->input('scheduled_date');
             $doctorId = $request->input('doctor_id');
             $scheduled_time = $request->input('scheduled_time');
             if(!$date || !$doctorId || !$scheduled_time){
                return;    
             } 

            $start = new Carbon($scheduled_time);
            if(!$scheduleService->isAvailableInterval($date, $doctorId, $start)){
                $validator->errors()
                    ->add('available_time', 'La hora seleccinada ya se encuentra reservada por otro paciente.');
            }
         });
         if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }*/

       
        $created = Appointment::createForPatient($request, auth()->id());  

        if($created){
            $notification = 'La cita se ha registrado correctamente!';
        } else {
            $notification = 'ocurrio un error al registrar al paciente';
        }
        
        $notification = 'La cita se ha registrado correctamente!';
        return back()->with(compact('notification'));
        // return redirect('appointments');

    }

    public function showCancelForm(Appointment $appointment )
    {
        if($appointment->status == 'Confirmada' || $appointment->status == 'Reservada')
         $role = auth()->user()->role;
        return view('appointments.cancel', compact('appointment','role'));

        return redirect('/appointments');
    }


    public function postCancel(Appointment $appointment, Request $request)
    {
        if($request->has('justification')) {
            $cancellation = new CancelledAppointment();
        $cancellation->justification = $request->input('justification');
        $cancellation->cancelled_by_id = auth()->id();
        // $cancellation->appointment_id = ;
        // $cancellation->save();

        $appointment->cancellation()->save($cancellation);

        }
        $appointment->status = 'Cancelado';
        $appointment->save(); //update

        $notification =  'La cita se ah cancelado correctamente.';   
        return  redirect('/appointments')->with(compact('notification'));
    }

    public function postConfirm(Appointment $appointment)
    {
        $appointment->status = 'Confirmada';
        $appointment->save(); //update

        $notification =  'La cita se ah confirmado correctamente.';   
        return  redirect('/appointments')->with(compact('notification'));
    }


}
