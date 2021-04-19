<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Cache;
use App\Appointment;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    private function daysToMinutes($day){

        $hours = $day * 24;
        return $hours *60;

    }

    public function index()
    {
        $minutes = 1;

        $appointmentsByDay = Cache::remember('appointments_by_day', $minutes, function () {
           
            $results =  Appointment::select([
                DB::raw('DAYOFWEEK(scheduled_date) as day'),
                DB::raw('COUNT(*) as count')
                ])->groupBy(DB::raw('DAYOFWEEK(scheduled_date)'))
                ->whereIn('status', ['Confirmada,', 'Atendida'])
               ->get(['day','count'])
               ->mapWithKeys(function ($item) {
                return [$item['day'] => $item['count']];
            })->toArray();
            
            $counts = [];

            for($i=1; $i<=7; ++$i){

                if(array_key_exists($i, $results)){

                    $counts[] = $results[$i];
                } else {
                    $counts[] = 0;
                    }
            }

            return $counts; 
           
        });

        //dd($appointmentsByDay);
        return view('home', compact('appointmentsByDay'));
    }
}
