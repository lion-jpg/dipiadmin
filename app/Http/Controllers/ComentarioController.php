<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use Illuminate\Support\Facades\Storage;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comentarios = Comentario::with('user')->latest()->get();
        return view('comentarios.index', compact('comentarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comentarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required()|string|max:255',
                'contenido' => 'required()|string|max:1000',
                'user_id' => 'required()|exists:users,id',
                'comentarioable_id' => 'required()',
                'comentarioable_type' => 'required()|string',
                'imagen_com' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $imagenPath = null;

            if ($request->hasFile('imagen_com')) {
                try {
                    $imagen = $request->file('imagen_com');
                    $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                    $imagenPath = $imagen->storeAs('comentarios/imagenes', $nombreImagen, 'public');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al subir la imagen: ' . $e->getMessage());
                }
            }

            Comentario::create([
                'nombre' => $request->nombre,
                'contenido' => $request->contenido,
                'user_id' => $request->user_id,
                'comentarioable_id' => $request->comentarioable_id,
                'comentarioable_type' => $request->comentarioable_type,
                'imagen_com' => $imagenPath
            ]);

            return redirect()->back()
                ->with('success', 'Comentario creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el comentario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario)
    {
        return view('comentarios.show', compact('comentario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentario $comentario)
    {
        return view('comentarios.edit', compact('comentario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentario $comentario)
    {
        try {
            $request->validate([
                'nombre' => 'required()|string|max:255',
                'contenido' => 'required()|string|max:1000',
                'imagen_com' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('imagen_com')) {
                try {
                    // Eliminar imagen anterior si existe
                    if ($comentario->imagen_com) {
                        Storage::disk('public')->delete($comentario->imagen_com);
                    }
                    $imagen = $request->file('imagen_com');
                    $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                    $comentario->imagen_com = $imagen->storeAs('comentarios/imagenes', $nombreImagen, 'public');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al actualizar la imagen: ' . $e->getMessage());
                }
            }

            $comentario->update([
                'nombre' => $request->nombre,
                'contenido' => $request->contenido
            ]);

            return redirect()->back()
                ->with('success', 'Comentario actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el comentario: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario)
    {
        try {
            // Eliminar imagen si existe
            if ($comentario->imagen_com) {
                Storage::disk('public')->delete($comentario->imagen_com);
            }

            $comentario->delete();
            return redirect()->back()
                ->with('success', 'Comentario eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el comentario: ' . $e->getMessage());
        }
    }
}
