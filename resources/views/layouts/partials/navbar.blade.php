<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #37d2b6;">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{url('/home')}}" style="color: black;">Pasanaku</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="{{url('/home')}}" class="nav-link" style="color: black;">Home</a>
        </li>
        <li class="nav-item">
          <a href="{{url('/juegos/create')}}" class="nav-link" style="color: black;">Crear Juego</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('/logout')}}" style="color: black;">Cerrar Sesion</a>
          
        </li>
      </ul>
    </div>
  </div>
</nav>
