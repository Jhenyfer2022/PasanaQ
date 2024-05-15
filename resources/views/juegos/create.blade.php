@extends('layouts.app_in')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear Juego</h1>
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
                        <h3 class="card-title">Formulario</h3>
                    </div>
                    <form action="{{url('juegos')}}" method="post" encrypte="multipart/form-data">
                        @include('juegos.form')
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection