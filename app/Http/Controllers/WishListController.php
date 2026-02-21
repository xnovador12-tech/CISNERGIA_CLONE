<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar lista de favoritos del usuario
     */
    public function index()
    {
        $favoritos = WishList::where('user_id', Auth::id())
                              ->where('deseo', true)
                              ->with('producto.images')
                              ->latest()
                              ->get();

        return view('ECOMMERCE.wishlist.index', compact('favoritos'));
    }

    /**
     * Toggle favorito (agregar/quitar) - AJAX
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $resultado = WishList::toggle(Auth::id(), $request->producto_id);

        $totalFavoritos = WishList::where('user_id', Auth::id())
                                   ->where('deseo', true)
                                   ->count();

        return response()->json([
            'success' => true,
            'accion'  => $resultado['accion'],
            'message' => $resultado['accion'] === 'added'
                ? 'Producto agregado a favoritos'
                : 'Producto eliminado de favoritos',
            'total_favoritos' => $totalFavoritos,
        ]);
    }

    /**
     * Eliminar un favorito específico
     */
    public function destroy($id)
    {
        $wishlist = WishList::where('user_id', Auth::id())->findOrFail($id);
        $wishlist->delete();

        return back()->with('success', 'Producto eliminado de favoritos.');
    }

    /**
     * Verificar si un producto está en favoritos (AJAX)
     */
    public function check(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $existe = WishList::where('user_id', Auth::id())
                           ->where('producto_id', $request->producto_id)
                           ->where('deseo', true)
                           ->exists();

        return response()->json([
            'en_favoritos' => $existe,
        ]);
    }
}
