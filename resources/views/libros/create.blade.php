@extends('layouts.app') {{-- si tienes un layout base, si no puedes quitar esta línea --}}

@section('content')
<div class="container">
    <h1 class="mb-4">Agregar nuevo libro</h1>

    {{-- Mostrar errores de validación si los hay --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('libros.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Título del libro --}}
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}" required>
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ old('descripcion') }}</textarea>
        </div>

        {{-- Autor --}}
        <div class="mb-3">
            <label for="autor_id" class="form-label">Autor</label>
            <select name="autor_id" id="autor_id" class="form-select" required>
                <option value="">Selecciona un autor</option>
                @foreach($autores as $autor)
                    <option value="{{ $autor->id }}" {{ old('autor_id') == $autor->id ? 'selected' : '' }}>
                        {{ $autor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Imagen --}}
        <div class="mb-3">
            <label for="imagen" class="form-label">Portada (opcional)</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
        </div>

        {{-- Botón --}}
        <button type="submit" class="btn btn-primary">Guardar libro</button>
    </form>
</div>
@endsection
