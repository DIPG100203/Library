@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Editar Libro</h1>

    {{-- Errores --}}
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
    <form action="{{ route('libros.update', $libro) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Título --}}
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $libro->titulo) }}" required>
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ old('descripcion', $libro->descripcion) }}</textarea>
        </div>

        {{-- Autor --}}
        <div class="mb-3">
            <label for="autor_id" class="form-label">Autor</label>
            <select name="autor_id" id="autor_id" class="form-select" required>
                @foreach($autores as $autor)
                    <option value="{{ $autor->id }}" {{ $libro->autor_id == $autor->id ? 'selected' : '' }}>
                        {{ $autor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Imagen --}}
        <div class="mb-3">
            <label for="imagen" class="form-label">Portada (opcional)</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
            @if($libro->imagen)
                <p class="mt-2">Imagen actual:</p>
                <img src="{{ asset('storage/' . $libro->imagen) }}" width="120">
            @endif
        </div>

        <button type="submit" class="btn btn-success">💾 Guardar cambios</button>
        <a href="{{ route('libros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
