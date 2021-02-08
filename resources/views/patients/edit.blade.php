@extends('layouts.panel')

@section('content')

<div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Editar pacientes</h3>
                </div>
                <div class="col text-right">
                  <a href="{{ url('patients') }}" class="btn btn-sm btn-default"> Cancelar y volver</a>
                </div>
              </div>
            </div>
            
            <div class="card-body">
                @if($errors->any())
                 <div class="alert alert-danger" role="alert">
                    <ul>
                     @foreach($errors->all() as $error)
                        <li>{{  $error}}</li>
                     @endforeach
                    </ul>
                </div>
                 @endif

                <form action="{{ url('patients/' .$patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre del médico</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name',$patient->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="description">E-mail</label>
                        <input type="email" name="email" value="{{ old('email',$patient->email) }}" class="form-control">
                    </div>
                    <div class="form-group">
                         <label for="ci">CI</label>
                         <input type="number" name="ci" class="form-control" value="{{ old('ci',$patient->ci) }}">
                    </div>
                    <div class="form-group">
                         <label for="address">Dirección</label>
                         <input type="text" name="address" class="form-control"  value="{{ old('address',$patient->address) }}">
                    </div>
                    <div class="form-group">
                         <label for="phone">Télefono / móvil</label>
                         <input type="text" name="phone" class="form-control" value="{{ old('phone',$patient->phone) }}">
                    </div>
                    <div class="form-group">
                          <label for="password">Contraseña</label>
                          <input type="text" name="password" class="form-control" value="">
                          <p>puede agregar una contraseña si desea modificar la anterior</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Editar</button>
                    
                </form>

            </div>
</div>
      
@endsection
