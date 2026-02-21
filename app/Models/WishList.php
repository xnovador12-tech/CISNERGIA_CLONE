<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = 'wish_lists';

    protected $fillable = [
        'deseo',
        'user_id',
        'producto_id',
    ];

    protected $casts = [
        'deseo' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // ==================== SCOPES ====================

    public function scopeActivos($query)
    {
        return $query->where('deseo', true);
    }

    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ==================== MÉTODOS ESTÁTICOS ====================

    /**
     * Toggle favorito: si existe lo quita, si no existe lo agrega.
     * Retorna [accion => 'added'|'removed', wishlist => WishList|null]
     */
    public static function toggle(int $userId, int $productoId): array
    {
        $existing = self::where('user_id', $userId)
                        ->where('producto_id', $productoId)
                        ->first();

        if ($existing) {
            $existing->delete();
            return ['accion' => 'removed', 'wishlist' => null];
        }

        $wishlist = self::create([
            'user_id'     => $userId,
            'producto_id' => $productoId,
            'deseo'       => true,
        ]);

        return ['accion' => 'added', 'wishlist' => $wishlist];
    }

    /**
     * Obtener total estimado de los favoritos de un usuario
     */
    public static function totalEstimado(int $userId): float
    {
        return self::where('user_id', $userId)
                    ->where('deseo', true)
                    ->join('productos', 'wish_lists.producto_id', '=', 'productos.id')
                    ->sum('productos.precio');
    }
}
