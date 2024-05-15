@csrf
<?php
    if($juego == null){
        $nombre = "";
        $limite_maximo_de_integrantes  = 999;
        $limite_minimo_de_integrantes  = 2;
        $fecha_de_inicio  = "";
        $tiempo_por_turno  = "";
        $monto_dinero_individual  = "100";
        $tiempo_para_ofertar = "";
        $monto_minimo_para_ofertar = "100";
        $monto_penalizacion = "50";
    }else{
        $nombre = $juego->nombre;
        $limite_maximo_de_integrantes  = $juego->limite_maximo_de_integrantes;
        $limite_minimo_de_integrantes  = $juego->limite_minimo_de_integrantes;
        $fecha_de_inicio  = $juego->fecha_de_inicio;
        $tiempo_por_turno  = $juego->tiempo_por_turno;
        $monto_dinero_individual  = $juego->monto_dinero_individual;
        $tiempo_para_ofertar = $juego->tiempo_para_ofertar;
        $monto_minimo_para_ofertar = $juego->monto_minimo_para_ofertar;
        $monto_penalizacion = $juego->monto_penalizacion;
    }
?>

<div class="card-body">
    <div class="form-group">
        <label for="nombre">Nombre del Juego:</label>
        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" value="{{$nombre}}" required>
    </div>

    <div class="form-group">
        <label for="limite_maximo_de_integrantes">Limite maximo de integrantes:</label>
        <input type="number" name="limite_maximo_de_integrantes" class="form-control" id="limite_maximo_de_integrantes" value="{{$limite_maximo_de_integrantes}}" required>
    </div>

    <div class="form-group">
        <label for="limite_minimo_de_integrantes">Limite minimo de integrantes:</label>
        <input type="number" name="limite_minimo_de_integrantes" class="form-control" id="limite_minimo_de_integrantes" value="{{$limite_minimo_de_integrantes}}" required>
    </div>
    
    <div class="form-group">
        <label for="fecha_de_inicio">Fecha de inicio del Juego:</label>
        <input type="datetime-local" name="fecha_de_inicio" class="form-control" id="fecha_de_inicio" value="{{$fecha_de_inicio}}" required>
    </div>

    <div class="form-group">
        <label for="tiempo_por_turno">Tiempo por cada turno:</label>
        <input type="time" name="tiempo_por_turno" class="form-control" id="tiempo_por_turno" value="{{$tiempo_por_turno}}" step="1" required>
    </div>

    <div class="form-group">
        <label for="monto_dinero_individual">Cantidad de dinero por jugador:</label>
        <input type="number" name="monto_dinero_individual" class="form-control" id="monto_dinero_individual" value="{{$monto_dinero_individual}}" required>
    </div>

    <div class="form-group">
        <label for="monto_minimo_para_ofertar">Cantidad de dinero minimo para ofertar:</label>
        <input type="number" name="monto_minimo_para_ofertar" class="form-control" id="monto_minimo_para_ofertar" value="{{$monto_minimo_para_ofertar}}" required>
    </div>
    
    <div class="form-group">
        <label for="tiempo_para_ofertar">Tiempo para ofertar:</label>
        <input type="time" id="tiempo_para_ofertar" name="tiempo_para_ofertar" class="form-control" step="1" value="{{$tiempo_para_ofertar}}" required>
    </div>

    <div class="form-group">
        <label for="monto_penalizacion">Monto de Penalizacion:</label>
        <input type="time" id="monto_penalizacion" name="monto_penalizacion" class="form-control" step="1" value="{{$monto_penalizacion}}" required>
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