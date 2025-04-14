<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proteccion;
use Illuminate\Support\Facades\Storage;

class ProteccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $protecciones = Proteccion::all();
        return view('protecciones.index', compact('protecciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('protecciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'titulo_pro' => 'required()',
                'descripcion_pro' => 'required()',
                'imagen_pro' => 'required()|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video_pro' => 'nullable|file|mimes:mp4,mov,avi|max:10240'
            ]);

            $imagenPath = null;
            $videoPath = null;

            if ($request->hasFile('imagen_pro')) {
                try {
                    $imagen = $request->file('imagen_pro');
                    $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                    $imagenPath = $imagen->storeAs('protecciones/imagenes', $nombreImagen, 'public');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al subir la imagen: ' . $e->getMessage());
                }
            }

            if ($request->hasFile('video_pro')) {
                try {
                    $video = $request->file('video_pro');
                    $nombreVideo = time() . '_' . $video->getClientOriginalName();
                    $videoPath = $video->storeAs('protecciones/videos', $nombreVideo, 'public');
                } catch (\Exception $e) {
                    // Si falla la subida del video, eliminamos la imagen si se subió
                    if ($imagenPath) {
                        Storage::disk('public')->delete($imagenPath);
                    }
                    return back()->with('error', 'Error al subir el video: ' . $e->getMessage());
                }
            }

            Proteccion::create([
                'titulo_pro' => $request->titulo_pro,
                'descripcion_pro' => $request->descripcion_pro,
                'imagen_pro' => $imagenPath,
                'video_pro' => $videoPath
            ]);

            return redirect()->route('protecciones.index')
                ->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el registro: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Proteccion $proteccion)
    {
        return view('protecciones.show', compact('proteccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proteccion $proteccion)
    {
        return view('protecciones.edit', compact('proteccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proteccion $proteccion)
    {
        try {
            $request->validate([
                'titulo_pro' => 'required()',
                'descripcion_pro' => 'required()',
                'imagen_pro' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video_pro' => 'nullable|file|mimes:mp4,mov,avi|max:10240'
            ]);

            if ($request->hasFile('imagen_pro')) {
                try {
                    // Eliminar imagen anterior si existe
                    if ($proteccion->imagen_pro) {
                        Storage::disk('public')->delete($proteccion->imagen_pro);
                    }
                    $imagen = $request->file('imagen_pro');
                    $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                    $proteccion->imagen_pro = $imagen->storeAs('protecciones/imagenes', $nombreImagen, 'public');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al actualizar la imagen: ' . $e->getMessage());
                }
            }

            if ($request->hasFile('video_pro')) {
                try {
                    // Eliminar video anterior si existe
                    if ($proteccion->video_pro) {
                        Storage::disk('public')->delete($proteccion->video_pro);
                    }
                    $video = $request->file('video_pro');
                    $nombreVideo = time() . '_' . $video->getClientOriginalName();
                    $proteccion->video_pro = $video->storeAs('protecciones/videos', $nombreVideo, 'public');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al actualizar el video: ' . $e->getMessage());
                }
            }

            $proteccion->update([
                'titulo_pro' => $request->titulo_pro,
                'descripcion_pro' => $request->descripcion_pro
            ]);

            return redirect()->route('protecciones.index')
                ->with('success', 'Registro actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el registro: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proteccion $proteccion)
    {
        try {
            // Eliminar archivos asociados
            if ($proteccion->imagen_pro) {
                Storage::disk('public')->delete($proteccion->imagen_pro);
            }
            if ($proteccion->video_pro) {
                Storage::disk('public')->delete($proteccion->video_pro);
            }

            $proteccion->delete();
            return redirect()->route('protecciones.index')
                ->with('success', 'Registro eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }
}
