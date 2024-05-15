@csrf
<?php
    if($juego == null){
        $nombre = "";
        $limite_maximo_de_integrantes  = 999;
        $limite_minimo_de_integrantes  = 2;
        $fecha_de_inicio  = "";
        $intervalo_tiempo  = 1;
        $monto_dinero_individual  = 100;
        $tiempo_para_ofertar = "";
    }else{
        $nombre = $juego->nombre;
        $limite_maximo_de_integrantes  = $juego->limite_maximo_de_integrantes;
        $limite_minimo_de_integrantes  = $juego->limite_minimo_de_integrantes;
        $fecha_de_inicio  = $juego->fecha_de_inicio;
        $intervalo_tiempo  = $juego->intervalo_tiempo;
        $monto_dinero_individual  = $juego->monto_dinero_individual;
        $tiempo_para_ofertar = $juego->tiempo_para_ofertar;
    }
?>

<div class="card-body">
    <div class="form-group">
        <label for="nombre">Nombre del Juego:</label>
        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" value="{{$nombre}}">
    </div>

    <div class="form-group">
        <label for="limite_maximo_de_integrantes">Limite maximo de integrantes:</label>
        <input type="number" name="limite_maximo_de_integrantes" class="form-control" id="limite_maximo_de_integrantes" value="{{$limite_maximo_de_integrantes}}">
    </div>

    <div class="form-group">
        <label for="limite_minimo_de_integrantes">Limite minimo de integrantes:</label>
        <input type="number" name="limite_minimo_de_integrantes" class="form-control" id="limite_minimo_de_integrantes" value="{{$limite_minimo_de_integrantes}}">
    </div>
    
    <div class="form-group">
        <label for="fecha_de_inicio">Fecha de inicio del Juego:</label>
        <input type="date" name="fecha_de_inicio" class="form-control" id="fecha_de_inicio" value="{{$fecha_de_inicio}}">
    </div>

    <div class="form-group">
        <label for="intervalo_tiempo">Tiempo de cada turno:</label>
        <input type="number" name="intervalo_tiempo" class="form-control" id="intervalo_tiempo" value="{{$intervalo_tiempo}}">
    </div>

    <div class="form-group">
        <label for="monto_dinero_individual">Cantidad de dinero por jugador:</label>
        <input type="number" name="monto_dinero_individual" class="form-control" id="monto_dinero_individual" value="{{$monto_dinero_individual}}">
    </div>
    
    <div class="form-group">
        <label for="tiempo_para_ofertar">Tiempo para ofertar:</label>
        <input type="time" id="tiempo_para_ofertar" name="tiempo_para_ofertar" class="form-control" step="1" value="{{$tiempo_para_ofertar}}" required>
    </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
    <div class="row">
        <div class="col-6">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-danger" href="{{url('/home')}}">
                Volver
            </a>
        </div>
    </div>
</div>