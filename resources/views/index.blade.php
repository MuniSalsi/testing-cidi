@extends('layouts.app')

@section('contenido')
    <section>
        <h1>Bienvenido</h1>
        <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesion</a>
    </section>
@endsection

@push('scripts')
    <script>
        // Mostrar SweetAlert basado en la sesión
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    title: '¡Inicio de sesión exitoso!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });
    </script>
@endpush
