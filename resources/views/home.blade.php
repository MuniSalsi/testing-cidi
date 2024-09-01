@extends('layouts.app')

@push('name')
@endpush

@section('contenido')
    <main class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h2 class="card-title mb-4">Bienvenido a Nuestra Aplicación</h2>
                            <p class="card-text mb-4">Para acceder a la aplicación, por favor inicie sesión usando el
                                siguiente botón.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Iniciar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
