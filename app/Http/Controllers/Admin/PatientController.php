<?php

namespace App\Http\Controllers\Admin;

use App\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PatientController extends Controller
{
    
    public function index(){

         $patients =  User::Patients()->paginate(5);

        return view('patients/index', compact('patients')); 

    }

    public function create(){

        return view('patients/create');
    }

    public function store(Request $request){

       // dd($request->all());

        $rule = [

            'name' => 'required | min:3',
            'email' => 'required | email',
            'ci' => 'required |digits:8',
            'addres' => 'nullable | min:5',
            'phone' => 'nullable | min:6'
        ];
        $this->validate( $request,$rule);

        User::create($request->only('name', 'email', 'ci', 'address', 'phone')
        
                    +[
                        'role' => 'patient',
                        'password' => bcrypt($request->password)
                    ]
            );

            $notification = "el paciente ah sido registrado";
            return redirect('patients')->with(compact('notification'));
    }

    public function edit($id){

         $patient = User::Patients()->findOrFail($id);

        // dd($patients);

         return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id){

        $rule = [
                'name' => 'required | min:3',
                'email' => 'required | email',
                'ci' => 'required | digits:8',
                'addres' => 'nullable | min:5',
                'phone' => 'nullable | min:6'
        ];
        $this->validate($request, $rule);


        $user = User::Patients()->findOrFail($id);

        $data = $request->only('name', 'email', 'ci' , 'address', 'phone');
        $password = $request->password;
        $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();

        $notification = "el paciente ah sido modificaso satisfactoriamente";

        return redirect('/patients')->with(compact('notification'));
    }

    public function destroy(User $patient){

        $patientName = $patient->name;

        $patient->delete();

        $notification = "el paciente $patientName ah sido eliminado satisfactoriamente";

        return  redirect('/patients')->with(compact('notification'));

    }
}
