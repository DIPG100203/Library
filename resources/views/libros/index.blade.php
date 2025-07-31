@extends('layouts.app') {{-- Si no tienes un layout, puedes quitar esta línea --}}

@section('content')
<div class="container">
    <h1 class="mb-4">📚 Lista de Libros</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Botón para agregar nuevo libro --}}
    <div class="mb-3">
        <a href="{{ route('libros.create') }}" class="btn btn-primary">➕ Agregar Libro</a>
        <a href="{{ route('autores.create') }}" class="btn btn-secondary">➕ Agregar Autor</a>
    </div>

    @if($libros->count())
        <div class="row">
            @foreach($libros as $libro)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        {{-- Imagen --}}
                        @if($libro->imagen)
                            <img src="{{ asset('storage/' . $libro->imagen) }}" class="card-img-top" alt="Portada de {{ $libro->titulo }}">
                        @else
                            <img src="https://via.placeholder.com/150x220?text=Sin+Imagen" class="card-img-top" alt="Sin imagen">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $libro->titulo }}</h5>
                            <p class="card-text text-muted">Autor: {{ $libro->autor->nombre }}</p>
                            <p class="card-text">{{ Str::limit($libro->descripcion, 100) }}</p>

                            <div class="mt-auto">
                                {{-- Botón Editar --}}
                                <a href="{{ route('libros.edit', $libro) }}" class="btn btn-warning btn-sm">✏️ Editar</a>

                                {{-- Formulario para eliminar --}}
                                <form action="{{ route('libros.destroy', $libro) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este libro?')">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay libros registrados todavía.</p>
    @endif
</div>
@endsection
