<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Lista los productos paginados.
     */
    public function index()
    {
        $products = Product::orderBy('name')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Formulario para crear un nuevo producto.
     * Además pasa todas las categorías disponibles.
     */
    public function create()
    {
        // Trae todas las categorías maestras
        $categories = Category::orderBy('name')
                              ->pluck('name')
                              ->toArray();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:255|unique:products,code',
            'price'       => 'required|numeric|min:0',
            'category'    => [
                'required',
                'string',
                'max:255',
                Rule::in(Category::pluck('name')->toArray()),
            ],
            'image'       => 'nullable|image|max:2048',
            'available'   => 'required|boolean',
            'minQuantity' => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Formulario para editar un producto existente.
     * También pasa todas las categorías disponibles.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')
                              ->pluck('name')
                              ->toArray();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Actualiza un producto existente.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => ['required','string','max:255', Rule::unique('products','code')->ignore($product->id)],
            'price'       => 'required|numeric|min:0',
            'category'    => [
                'required',
                'string',
                'max:255',
                Rule::in(Category::pluck('name')->toArray()),
            ],
            'image'       => 'nullable|image|max:2048',
            'available'   => 'required|boolean',
            'minQuantity' => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Producto eliminado.');
    }

    /**
     * Carga masiva de productos desde CSV.
     */
    public function massUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $rows = array_map('str_getcsv', file($request->file('file')->getRealPath()));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);

            Product::updateOrCreate(
                ['code' => $data['code']],
                [
                    'name'        => $data['name'],
                    'price'       => $data['price'],
                    'category'    => $data['category'],
                    'available'   => $data['available'] ?? 1,
                    'minQuantity' => $data['minQuantity'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Productos cargados masivamente correctamente.');
    }
}
