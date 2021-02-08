@extends('layouts.panel')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

<div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Nuevo Médicos</h3>
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

                <form action="{{ url('doctors') }}" method="POST">
                        @csrf
                    <div class="form-group">
                        <label for="name">Nombre del médico</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="description">E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                    </div>
                    <div class="form-group">
                         <label for="ci">CI</label>
                         <input type="number" name="ci" class="form-control" value="{{ old('ci') }}">
                    </div>
                    <div class="form-group">
                         <label for="address">Dirección</label>
                         <input type="text" name="address" class="form-control"  value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                         <label for="phone">Télefono / móvil</label>
                         <input type="number" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                          <label for="password">Contraseña</label>
                          <input type="text" name="password" class="form-control" value="{{ str_random(6) }}" >
                    </div>
                    <divclass="form-group" > 
                        <label for="specialties">Especialidades</label>
                        <select name="specialties[]" id="specialties" class="form-control selectpicker" data-style="btn-primary" multiple title="seleccione uno o varios">
                          @foreach($specialties as $specialtys)
                            <option value="{{ $specialtys->id }}">{{ $specialtys->name }}</option>
                          @endforeach
                        </select>

                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    
                </form>

            </div>
</div> 
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
