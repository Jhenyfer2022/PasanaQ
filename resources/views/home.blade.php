@extends('layouts.app_in')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: absolute; top: 20px; right: 20px;">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Éxito</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tus Juegos</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Ingresaste correctamente!') }}
                    <br>
                    <br>

                    <div class="row">
                        @foreach ($juegos as $juego)
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        Id juego: {{ $juego->id }}
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Nombre: {{ $juego->nombre }}</h5>
                                        <p class="card-text">Estado: {{ $juego->estado }}</p>
                                        <a href="{{url('/juegos/'.$juego->id)}}" class="btn btn-primary">Ver juego</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".toast").toast('show');
    });
</script>
@endsection
