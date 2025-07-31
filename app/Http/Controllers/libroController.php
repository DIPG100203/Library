<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Autor;


class libroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libros = Libro::with('autor')->latest()->get();
        return view('libros.index', compact('libros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $autores = Autor::all();
        return view('libros.create', compact('autores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'requiered',
            'descripcion' => 'nullable',
            'autor_id' => 'requiered|exists:autors,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagenPath = null;
        if ($request-> hasFile('imagen')){
            $imagenPath = $request->file('imagen')->store('portadas', 'public');
        }

        Libro::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'autor_id' => $request->autor_id,
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('libros.index')->with('success', 'Libro agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Libro $libro)
    {
        $autores = \App\Models\Autor::all();
        return view('libros.edit', compact('libro', 'autores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'autor_id' => 'required|exists:autors,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        //checa si hay una imagen nueva
        //si hay una imagen nueva, elimina la anterior
        //y guarda la nueva imagen
        $imagenPath = $libro->imagen;
        if ($request->hasFile('imagen')) {
            if ($imagenPath) {
                \Storage::disk('public')->delete($imagenPath);
            }
            $imagenPath = $request->file('imagen')->store('portadas', 'public');
        }
        //actualiza el libro con los nuevos datos
        $libro->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'autor_id' => $request->autor_id,
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('libros.index')->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Libro $libro)
    {
        if ($libro->imagen && \Storage::disk('public')->exists($libro->imagen)) {
            \Storage::disk('public')->delete($libro->imagen);
        }
        $libro->delete();

        return redirect()->route('libros.index')->with('success', 'Libro eliminado exitosamente.');
    }
}
