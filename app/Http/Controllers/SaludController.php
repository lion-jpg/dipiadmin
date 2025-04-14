<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salud;
use Illuminate\Support\Facades\Storage;

class SaludController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saluds = Salud::all();
        return view('saluds.index', compact('saluds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('saluds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'titulo_sal' => 'required',
                'descripcion_sal' => 'required',
                'imagen_sal' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video_sal' => 'nullable|file|mimes:mp4,mov,avi|max:102400'
            ]);

            $imagenPath = null;
            $videoPath = null;

            if ($request->hasFile('video_sal')) {
                try {
                    $video = $request->file('video_sal');
                    $nombreVideo = time() . '_' . $video->getClientOriginalName();
                    $videoPath = $video->storeAs('saluds/videos', $nombreVideo, 'public');
                } catch (\Exception $e) {
                    if ($imagenPath) {
                        Storage::disk('public')->delete($imagenPath);
                    }
                    return back()->with('error', 'Error al subir el video: ' . $e->getMessage());
                }
            }
            
            Salud::create([
                'titulo_sal' => $request->titulo_sal,
                'descripcion_sal' => $request->descripcion_sal,
                'imagen_sal' => $imagenPath,
                'video_sal' => $videoPath
            ]);

            return redirect()->route('saluds.index')
                ->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el registro: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Salud $salud)
    {
        return view('saluds.show', compact('salud'));
    }

    /** 
     * Show the form for editing the specified resource.
     */
    public function edit(Salud $salud)
    {
        return view('saluds.edit', compact('salud'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salud $salud)
    {
        try {
            $request->validate([
                'titulo_sal' => 'required',
                'descripcion_sal' => 'required',
                'imagen_sal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video_sal' => 'nullable|file|mimes:mp4,mov,avi|max:102400'
            ]);

            if ($request->hasFile('imagen_sal')) {
                try {
                    // Eliminar imagen anterior si existe
                    if ($salud->imagen_sal) {
                        Storage::disk('public')->delete($salud->imagen_sal);
                    }
                    $imagen = $request->file('imagen_sal');
                    $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                    $salud->imagen_sal = $imagen->storeAs('saluds/imagenes', $nombreImagen, 'public');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al actualizar la imagen: ' . $e->getMessage());
                }
            }

            if ($request->hasFile('video_sal')) {
                try {
                    // Eliminar video anterior si existe
                    if ($salud->video_sal) {
                        Storage::disk('public')->delete($salud->video_sal);
                    }
                    $video = $request->file('video_sal');
                    $nombreVideo = time() . '_' . $video->getClientOriginalName();
                    $videoPath = $video->storeAs('saluds/videos', $nombreVideo, 'public');
                    $salud->video_sal = $videoPath; // Asegúrate de asignarlo
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al actualizar el video: ' . $e->getMessage());
                }
            }
            
            $salud->update([
                'titulo_sal' => $request->titulo_sal,
                'descripcion_sal' => $request->descripcion_sal,
                'imagen_sal' => $salud->imagen_sal, // Mantén la imagen existente si no se actualiza
                'video_sal' => $salud->video_sal,   // Mantén el video existente o actualizado
            ]);

            return redirect()->route('saluds.index')
                ->with('success', 'Registro actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el registro: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salud $salud)
    {
        try {
            // Eliminar archivos asociados
            if ($salud->imagen_sal) {
                Storage::disk('public')->delete($salud->imagen_sal);
            }
            if ($salud->video_sal) {
                Storage::disk('public')->delete($salud->video_sal);
            }

            $salud->delete();
            return redirect()->route('saluds.index')
                ->with('success', 'Registro eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }
}
