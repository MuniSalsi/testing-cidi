@extends('layouts.app')

@section('contenido')
    <main class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Iniciar sesión con CIDI</h5>
                            <p class="card-text">Para acceder a la aplicación, debes iniciar sesión utilizando CIDI. Por
                                favor, haz clic en el enlace a continuación para iniciar el proceso.</p>
                            <a href="https://cidi.cba.gov.ar/Cuenta/Login?app=614" class="btn btn-primary">Iniciar sesión con
                                CIDI</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    title: '¡Cierre de sesión exitoso!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });
    </script>
@endpush
