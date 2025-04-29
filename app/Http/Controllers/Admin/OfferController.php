<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::latest()->paginate(15);
        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.offers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image'             => 'required|image',
            'alt'               => 'required|string|max:255',
            'promotion_message' => 'required|string',
            'active'            => 'sometimes|boolean',
        ]);

        // Procesar subida de imagen
        if ($request->hasFile('image')) {
            // Ajusta el disco ('public') y la carpeta según tu configuración
            $data['image'] = $request->file('image')->store('offers', 'public');
        }

        // Asegurar booleano
        $data['active'] = $request->boolean('active');

        Offer::create($data);

        return redirect()->route('admin.offers.index')
                         ->with('success', 'Oferta creada correctamente.');
    }

    public function edit(Offer $offer)
    {
        return view('admin.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $data = $request->validate([
            'image'             => 'sometimes|image',
            'alt'               => 'required|string|max:255',
            'promotion_message' => 'required|string',
            'active'            => 'sometimes|boolean',
        ]);

        // Si suben nueva imagen, reemplazamos
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('offers', 'public');
        }

        $data['active'] = $request->boolean('active');

        $offer->update($data);

        return redirect()->route('admin.offers.index')
                         ->with('success', 'Oferta actualizada correctamente.');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('admin.offers.index')
                         ->with('success', 'Oferta eliminada correctamente.');
    }
}
