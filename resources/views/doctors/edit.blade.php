@extends('layouts.panel')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

<div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Editar Médicos</h3>
                </div>
                <div class="col text-right">
                  <a href="{{ url('doctors') }}" class="btn btn-sm btn-default"> Cancelar y volver</a>
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

                <form action="{{ url('doctors/' .$doctor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre del médico</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name',$doctor->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="description">E-mail</label>
                        <input type="email" name="email" value="{{ old('email',$doctor->email) }}" class="form-control">
                    </div>
                    <div class="form-group">
                         <label for="ci">CI</label>
                         <input type="number" name="ci" class="form-control" value="{{ old('ci',$doctor->ci) }}">
                    </div>
                    <div class="form-group">
                         <label for="address">Dirección</label>
                         <input type="text" name="address" class="form-control"  value="{{ old('address',$doctor->address) }}">
                    </div>
                    <div class="form-group">
                         <label for="phone">Télefono / móvil</label>
                         <input type="text" name="phone" class="form-control" value="{{ old('phone',$doctor->phone) }}">
                    </div>
                    <div class="form-group">
                          <label for="password">Contraseña</label>
                          <input type="text" name="password" class="form-control" value="">
                          <p>puede agregar una contraseña si desea modificar la anterior</p>
                    </div>
                    <div class="form-group">
                          <label for="specialties">Especialidades</label>
                          <select name="specialties[]" id="specialties" class="form-control selectpicker" data-style="btn-primary" multiple title="seleccione uno o varios" >
                               @foreach($specialties as $specialtys)
                               <option value="{{ $specialtys->id }}">{{ $specialtys->name }}</option>
                               @endforeach
                          </select >
                    </div>
                    <button type="submit" class="btn btn-primary">Editar</button>
                    
                </form>

            </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
$(document).ready( () =>{
  $('#specialties').selectpicker('val', @json($specialties_ids));
});

</script>
@endsection



