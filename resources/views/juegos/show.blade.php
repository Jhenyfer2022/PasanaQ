@extends('layouts.app_in')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Juego: {{$juego->nombre}}</h1>
            </div>
        </div>
    </div>
</section>
<!-- Formulario --> 
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Datos del Juego</h3>
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
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-5 m-2 p-3 border border-dark rounded">
                                <!-- Primer formulario -->
                                Jugadores en espera
                            </div>
                            <div class="col-md-5 m-2 p-3 border border-dark rounded">
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
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div>
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
@endsection




