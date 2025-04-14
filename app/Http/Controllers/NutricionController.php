<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nutricion;

class NutricionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nutriciones = Nutricion::all();
        return view('nutriciones.index', compact('nutriciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nutriciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo_nut' => 'required',
            'descripcion_nut' => 'required',
            'imagen_nut' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_nut' => 'nullable|file|mimes:mp4,mov,avi|max:10240'
        ]);

        $imagenPath = null;
        $videoPath = null;

        if ($request->hasFile('imagen_nut')) {
            $imagenPath = $request->file('imagen_nut')->store('nutriciones/imagenes', 'public');
        }

        if ($request->hasFile('video_nut')) {
            $videoPath = $request->file('video_nut')->store('nutriciones/videos', 'public');
        }

        Nutricion::create([
            'titulo_nut' => $request->titulo_nut,
            'descripcion_nut' => $request->descripcion_nut,
            'imagen_nut' => $imagenPath,
            'video_nut' => $videoPath
        ]);

        return redirect()->route('nutriciones.index')
            ->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nutricion $nutricion)
    {
        return view('nutriciones.show', compact('nutricion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nutricion $nutricion)
    {
        return view('nutriciones.edit', compact('nutricion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nutricion $nutricion)
    {
        $request->validate([
            'titulo_nut' => 'required',
            'descripcion_nut' => 'required',
            'imagen_nut' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_nut' => 'nullable|file|mimes:mp4,mov,avi|max:10240'
        ]);

        if ($request->hasFile('imagen_nut')) {
            $nutricion->imagen_nut = $request->file('imagen_nut')->store('nutriciones/imagenes', 'public');
        }

        if ($request->hasFile('video_nut')) {
            $nutricion->video_nut = $request->file('video_nut')->store('nutriciones/videos', 'public');
        }

        $nutricion->update([
            'titulo_nut' => $request->titulo_nut,
            'descripcion_nut' => $request->descripcion_nut
        ]);

        return redirect()->route('nutriciones.index')
            ->with('success', 'Registro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nutricion $nutricion)
    {
        $nutricion->delete();
        return redirect()->route('nutriciones.index')
            ->with('success', 'Registro eliminado exitosamente.');
    }
}
