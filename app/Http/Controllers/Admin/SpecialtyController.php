<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Specialty;

use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{

   public function __construct(){
       $this->middleware('auth');
   }
    

  public function index(){

     $specialities = Specialty::all();
      return view('specialties.index', compact('specialities'));
  }

  public function create(){
      return view('specialties.create');
  }


  private function performValidation(Request $request){
        $rules = [
            'name' => 'required|min:3'
        ];
        $messages = [
            'name.required'=> 'es necesario ingresar un nombre',
            'name.min' => 'es necesario ingresar nombre con mas de tres caracteres'
        ];

    $this->validate($request,$rules,$messages);
  }

  public function store(Request $request){

    // dd($request->all());

        $this->performValidation($request);

        $specialty = new Specialty();

        $specialty->name = $request->name;
        $specialty->description = $request->description;
        $specialty->save();

        $notification = 'se ha Registrado la Especialidad';
        return redirect('/specialties')->with(compact('notification'));
  }

  public function edit(Specialty $specialty){

    return view('specialties.edit', compact('specialty'));
  }

  public function update(Request $request, Specialty $specialty){

      $this->performValidation($request);
      
      $specialty->name = $request->name;
      $specialty->description = $request->description;
      $specialty->save();
      $notification = "se ah Actualizado la Especialidad";
      return redirect('/specialties')->with(compact('notification'));
  }

  public function destroy(Specialty $specialty){

    $specialty->delete();
    $notification = "se ah Eliminado la Especialidad";
    return redirect('/specialties')->with(compact('notification'));
  }

}
