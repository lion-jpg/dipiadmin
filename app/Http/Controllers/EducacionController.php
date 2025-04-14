<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Educacion;

class EducacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $educaciones = Educacion::all();
        return view('educaciones.index', compact('educaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('educaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo_edu' => 'required',
            'descripcion_edu' => 'required',
            'imagen_edu' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_edu' => 'nullable|file|mimes:mp4,mov,avi|max:10240'
        ]);

        $imagenPath = null;
        $videoPath = null;

        if ($request->hasFile('imagen_edu')) {
            $imagenPath = $request->file('imagen_edu')->store('educaciones/imagenes', 'public');
        }

        if ($request->hasFile('video_edu')) {
            $videoPath = $request->file('video_edu')->store('educaciones/videos', 'public');
        }

        Educacion::create([
            'titulo_edu' => $request->titulo_edu,
            'descripcion_edu' => $request->descripcion_edu,
            'imagen_edu' => $imagenPath,
            'video_edu' => $videoPath
        ]);

        return redirect()->route('educaciones.index')
            ->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Educacion $educacion)
    {
        return view('educaciones.show', compact('educacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Educacion $educacion)
    {
        return view('educaciones.edit', compact('educacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Educacion $educacion)
    {
        $request->validate([
            'titulo_edu' => 'required',
            'descripcion_edu' => 'required',
            'imagen_edu' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_edu' => 'nullable|file|mimes:mp4,mov,avi|max:10240'
        ]);

        if ($request->hasFile('imagen_edu')) {
            $educacion->imagen_edu = $request->file('imagen_edu')->store('educaciones/imagenes', 'public');
        }

        if ($request->hasFile('video_edu')) {
            $educacion->video_edu = $request->file('video_edu')->store('educaciones/videos', 'public');
        }

        $educacion->update([
            'titulo_edu' => $request->titulo_edu,
            'descripcion_edu' => $request->descripcion_edu
        ]);

        return redirect()->route('educaciones.index')
            ->with('success', 'Registro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Educacion $educacion)
    {
        $educacion->delete();
        return redirect()->route('educaciones.index')
            ->with('success', 'Registro eliminado exitosamente.');
    }
}
