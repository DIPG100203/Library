@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Autor</h1>

    <form action="{{ route('autores.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre del autor:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
    </form>
</div>
@endsection
