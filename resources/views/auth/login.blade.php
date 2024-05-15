@extends('layouts.app_out')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 60%; border-radius: 1rem;">
            <div class="row">
                <div class="col-md-6 col-lg-5 d-none d-md-block">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                </div>
                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                    <div class="card-body p-4 p-lg-5 text-black">
                        <div class="d-flex align-items-center mb-3 pb-1">
                            <span class="h1 fw-bold mb-0">Iniciar sesión</span>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">
                                    <strong>
                                        Correo electrónico
                                    </strong>
                                </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">
                                    <strong>
                                        Contraseña
                                    </strong>
                                </label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-dark btn-lg btn-block">Iniciar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection