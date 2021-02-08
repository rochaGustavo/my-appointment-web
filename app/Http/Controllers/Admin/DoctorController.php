<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Specialty;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $doctors = User::doctors()->paginate(5);
       return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $specialties =  Specialty::all();
        return view('doctors.create',compact('specialties'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $rule = [
            'name' => 'required | min:3',
            'email' => 'required | email',
            'ci' => 'nullable | digits:8',
            'address' => 'nullable |min:5',
            'phone' => 'nullable | min:6'
        ];


        $this->validate($request , $rule);

        $user = User::create($request->only('name', 'email', 'ci', 'address', 'phone')
            + [

                'role' => 'doctor',
                'password' => bcrypt($request->password)
            ]
            );
        $user->specialties()->attach($request->input('specialties'));

            $notification= "el médico se ha registrado satisfactoriamente";

            return redirect('/doctors')->with(compact('notification'));


    }
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
         $doctor = User::Doctors()->findOrFail($id);

         $specialties = Specialty::all();

         $specialties_ids = $doctor->specialties()->pluck('specialties.id');

        // dd($doctor);

         return view('doctors.edit', compact('doctor','specialties','specialties_ids'));

    }

    public function update(Request $request, $id)
    {
        $rules = [
              'name' => 'required | min:3',
              'email' => 'required | email',
              'ci' => 'nullable | digits:8',
              'address' => 'nullable | min:5',
              'phone' => 'nullable | min:6'  
        ];
        $this->validate($request,$rules);

        $user = User::Doctors()->findOrFail($id);

        $data = $request->only('name','email','ci','address','phone');
        $password = $request->password;
        if($password)
        $data['password'] = bcrypt($password);

        $user->fill($data);

        $user->save(); // UPDATE

        $user->specialties()->sync($request->input('specialties'));

        $notification ="el medico se ha actulizado correctamente.";
        return redirect('/doctors')->with(compact('notification'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
         $doctorName = $doctor->name;
         $doctor->delete();

         $notification = "el medico $doctorName ha sido eliminado satisfactoriamente";

         return redirect('/doctors')->with(compact('notification'));

    }
}
