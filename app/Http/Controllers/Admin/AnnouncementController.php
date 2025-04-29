<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Muestra el listado de anuncios.
     */
    public function index()
    {
        $announcements = Announcement::orderBy('id','desc')->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Muestra el formulario para crear un nuevo anuncio.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Valida y guarda un nuevo anuncio.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'icon'  => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'text'  => 'required|string',
          ]);
          
          $data['active'] = $request->boolean('active');
          

        Announcement::create($data);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Anuncio creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un anuncio existente.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Valida y actualiza un anuncio.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'icon'   => 'required|string|max:255',
            'title'  => 'required|string|max:255',
            'text'   => 'required|string',
            'active' => 'sometimes|boolean',
        ]);

        $data['active'] = $request->has('active');

        $announcement->update($data);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Anuncio actualizado correctamente.');
    }

    /**
     * Elimina un anuncio.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return back()
            ->with('success', 'Anuncio eliminado correctamente.');
    }
}
