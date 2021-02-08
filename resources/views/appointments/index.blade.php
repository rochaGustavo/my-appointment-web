@extends('layouts.panel')

@section('content')

<div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Citas</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                @if(session('notification'))

                  <div class="alert alert-success" role="alert">
                        {{session('notification')}}
                  </div>
                @endif

                  <!-- Nav pills -->
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#confirmed-appointments">Mis Próximas citas</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#pending-appointments">Citas por confirmar</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#old-appointments">Historial de citas</a>
                  </li>
                </ul>
            </div>

             <!-- Tab panes -->
             <div class="tab-content">
                  <div class="tab-pane fade show active" id="confirmed-appointments">@include('appointments.tables.confirmed')</div>
                  <div class="tab-pane  fade" id="pending-appointments">@include('appointments.tables.pending')</div>
                  <div class="tab-pane  fade" id="old-appointments">@include('appointments.tables.old')</div>
                </div>

            
</div>
      
@endsection
