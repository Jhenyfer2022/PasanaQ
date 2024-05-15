@extends('layouts.app_in')
@section('content')
<!-- Formulario --> 
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h1>Juego: {{$juego->nombre}}</h1>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="row justify-content-center align-items-center" id="parentDivOne">
                            <h3>Datos del Juego</h3>

                            <div class="col-md-5 m-2 p-3" style="overflow-y: auto;">
                                <label for="limite_maximo_de_integrantes">Limite maximo de jugadores:</label>
                                <input type="text" class="form-control" id="limite_maximo_de_integrantes" value="{{$juego->limite_maximo_de_integrantes}}" readonly>
                                <label for="limite_minimo_de_integrantes">Limite minimo de jugadores:</label>
                                <input type="text" class="form-control" id="limite_minimo_de_integrantes" value="{{$juego->limite_minimo_de_integrantes}}" readonly>
                                <label for="fecha_de_inicio">Fecha de inicio:</label>
                                <input type="text" class="form-control" id="fecha_de_inicio" value="{{$juego->fecha_de_inicio}}" readonly>    
                            </div>
                            <div class="col-md-5 m-2 p-3" style="overflow-y: auto;">
                                <label for="estado">Estado:</label>
                                <input type="text" class="form-control" id="estado" value="{{$juego->estado}}" readonly>
                                <label for="tiempo_por_turno">Intervalo de tiempo en cada turno:</label>
                                <input type="text" class="form-control" id="tiempo_por_turno" value="{{$juego->tiempo_por_turno}}" readonly>
                                <label for="monto_dinero_individual">Monto de dinero que colocara cada jugador:</label>
                                <input type="text" class="form-control" id="monto_dinero_individual" value="{{$juego->monto_dinero_individual}}" readonly>
                            </div>
                        </div>
                        @if($juego->estado !== "No Iniciado")
                            <div class="row justify-content-center align-items-center" id="parentDivTwo">
                                <div class="col-md-5 m-2 p-3 border border-dark rounded" id="firstDiv" style="overflow-y: auto;">
                                    <!-- Primer formulario -->
                                    <h3>Listado de Jugadores</h3>
                                    <!-- Aquí puedes hacer tu foreach -->
                                    <table id="tablaJugadores" class="table">
                                        <thead>
                                            <tr>
                                                <th>Email/Telefono</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jugadores as $jugador)
                                                @if($jugador->estado === 'Aceptado')
                                                    <tr>
                                                        <td>{{ $jugador->identificador_invitacion }}</td>
                                                        <td>{{ $jugador->estado }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-5 m-2 p-3 border border-dark rounded" id="firstDiv" style="overflow-y: auto;">
                                    <!-- Primer formulario -->
                                    <h3>Listado de Turnos</h3>
                                    <!-- Aquí puedes hacer tu foreach -->
                                    <table id="tablaJugadores" class="table">
                                        <thead>
                                            <tr>
                                                <th>Nro</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($juego->turnos->sortBy('created_at') as $index => $turno)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $turno->fecha_inicio }}</td>
                                                    <td>{{ $turno->fecha_final }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if($juego->estado !== 'Iniciado')
                            <div class="row justify-content-center align-items-center" id="parentDivTwo">
                                <div class="col-md-5 m-2 p-3 border border-dark rounded" id="firstDiv" style="overflow-y: auto;">
                                    <!-- Primer formulario -->
                                    <h3>Listado de Jugadores</h3>
                                    <!-- Aquí puedes hacer tu foreach -->
                                    <table id="tablaJugadores" class="table">
                                        <thead>
                                            <tr>
                                                <th>Email/Telefono</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jugadores as $jugador)
                                            <tr>
                                                <td>{{ $jugador->identificador_invitacion }}</td>
                                                <td>{{ $jugador->estado }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col-md-5 m-2 p-3 border border-dark rounded" id="secondDiv">
                                    <!-- Segundo formulario -->
                                    <h2 style="text-align: center;" >Enviar invitacion</h2>
                                    <div class="row">
                                        <div class="col-md-11 m-1 p-3 border border-dark rounded">
                                            <form action="{{ url('/send-email-web') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="email">Enviar Invitacion por Correo:</label>
                                                    <input type="hidden" name="juego_id" value="{{ $juego->id }}">
                                                    <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="submit" class="btn btn-primary">Enviar Invitacion</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-11 m-1 p-3 border border-dark rounded">
                                            <form action="{{ url('/send-wpp-web') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="telephone">Enviar Invitacion por WhatsApp:</label>
                                                    <input type="hidden" name="juego_id" value="{{ $juego->id }}">
                                                    <input type="text" name="telephone" class="form-control" id="telephone" placeholder="Teléfono">
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="submit" class="btn btn-primary">Enviar Invitacion</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div>
                                @if($juego->estado !== 'Iniciado')
                                    <a class="btn btn-success" href="{{ url('/juego/' . $juego->id . '/iniciar_juego') }}">
                                        Iniciar Juego
                                    </a>
                                @endif
                                <a class="btn btn-danger" href="{{url('/home')}}">
                                    Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var secondDivHeight = document.getElementById("secondDiv").clientHeight;
        document.getElementById("firstDiv").style.height = secondDivHeight + "px";
    });
</script>
@endsection




