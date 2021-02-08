<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Appointment;
use App\User;
use Carbon\Carbon;
use DB;



class ChartController extends Controller
{
    public function appointments(){

        
            //Obtenemos el mes de  de la cita 
            /*Appointment::select(DB::raw('MONTH(created_at) as month'))
                ->groupBY('month')->get()->toArray() */
            
            $monthlyCounts = Appointment::select(DB::raw('MONTH(created_at) as month'),
                    DB:: raw('COUNT(1) as count')
                    )->groupBY('month')->get()->toArray();

                    // [[ 'month'=>11, 'count'=>3]]
                    //[0,0,0,0, ...., 3, 0]

            $counts = array_fill(0,12,0);

            foreach($monthlyCounts as $monthlycount) {
                $index = $monthlycount['month'] -1;
                $counts[$index] = $monthlycount['count'];
            }  
            
            //dd($counts);

        return view('charts.appointments', compact('counts'));

    }

    public function doctors()
    {
        $now = Carbon::now();
        $end = $now->format('Y-m-d');
        $start = $now->subYear()->format('Y-m-d');

        return view('charts.doctors', compact('start','end'));
    }

    public function doctorsJson(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        

        /*$doctor = User::doctors()->first();
        //return $doctor;
        dd($doctor->asDoctorAppointments); */

        $doctors = User::doctors()
                ->select('name')
                ->withCount([
                             'acepptedAppointments' => function($query) use($start, $end){
                                    $query->whereBetween('scheduled_date',[$start, $end]);
                             },
                             'cancelledAppointments' => function($query) use($start, $end){
                                   $query->whereBetween('scheduled_date',[$start,$end]);
                             }
                            ])
                ->orderBY('aceppted_appointments_count', 'desc')
                ->take(3)
                ->get();

                //->toArray() /para que nos muestre un array y no una collection de laravel 
        //dd($doctors);
        
        $data = [];
        $data['categories'] = $doctors->pluck('name');

        $series = [];

        //Atendida
        $series1['name'] ="Citas Atendidas";
        $series1['data'] = $doctors->pluck('aceppted_appointments_count');
        //Cancelada
        $series2['name'] = "Citas Canceladas";
        $series2['data'] = $doctors->pluck('cancelled_appointments_count');
        $series[] = $series1;
        $series[] = $series2;

        $data['series'] = $series;

        return $data;  // c{ategories: ['A','B'], series: [1,2] }
    }
}
