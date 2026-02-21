<?php

namespace App\Observers;

use App\Models\CartItem;
use App\Models\Oportunidad;
use App\Models\Prospecto;
use Illuminate\Support\Str;

class CartItemObserver
{
    /**
     * Se ejecuta después de crear un CartItem.
     *
     * Cuando un usuario agrega un producto al carrito:
     * 1. Busca el Prospecto vinculado al usuario
     * 2. Si no existe Oportunidad para ese carrito → crea una nueva
     * 3. Si ya existe → actualiza el monto estimado
     *
     * Esto permite al vendedor ver en el CRM qué productos
     * está considerando el cliente y contactarlo proactivamente.
     */
    public function created(CartItem $cartItem): void
    {
        $cart = $cartItem->cart;

        // Solo actuar si el carrito tiene un usuario autenticado
        if (!$cart || !$cart->user_id) {
            return;
        }

        // Buscar el prospecto vinculado al usuario
        $prospecto = Prospecto::where('registered_user_id', $cart->user_id)->first();

        // Si no hay prospecto (ej: usuario creado antes del Observer), no hacer nada
        if (!$prospecto) {
            return;
        }

        // Buscar oportunidad existente para este carrito
        $oportunidad = Oportunidad::where('cart_id', $cart->id)
            ->where('prospecto_id', $prospecto->id)
            ->first();

        if ($oportunidad) {
            // Ya existe: actualizar monto con el nuevo total del carrito
            $this->actualizarOportunidad($oportunidad, $cart);
        } else {
            // No existe: crear oportunidad nueva
            $this->crearOportunidad($prospecto, $cart, $cartItem);
        }

        // Subir estado del prospecto si todavía está en 'nuevo'
        if ($prospecto->estado === 'nuevo') {
            $prospecto->update([
                'estado'              => 'contactado',
                'nivel_interes'       => 'medio',
                'fecha_ultimo_contacto' => now(),
            ]);
        }
    }

    /**
     * Se ejecuta después de eliminar un CartItem.
     *
     * Si el carrito queda vacío, no eliminamos la oportunidad
     * (el vendedor podría querer contactar al cliente de todas formas).
     * Solo actualizamos el monto.
     */
    public function deleted(CartItem $cartItem): void
    {
        $cart = $cartItem->cart;

        if (!$cart || !$cart->user_id) {
            return;
        }

        $prospecto = Prospecto::where('registered_user_id', $cart->user_id)->first();

        if (!$prospecto) {
            return;
        }

        $oportunidad = Oportunidad::where('cart_id', $cart->id)
            ->where('prospecto_id', $prospecto->id)
            ->first();

        if ($oportunidad) {
            $this->actualizarOportunidad($oportunidad, $cart);
        }
    }

    /**
     * Crea una nueva oportunidad vinculada al carrito.
     */
    private function crearOportunidad(Prospecto $prospecto, $cart, CartItem $cartItem): void
    {
        $nombreProducto = $cartItem->nombre ?? 'Productos e-commerce';

        Oportunidad::create([
            'nombre'                  => "Carrito e-commerce - {$prospecto->nombre} {$prospecto->apellidos}",
            'prospecto_id'            => $prospecto->id,
            'etapa'                   => 'calificacion',
            'monto_estimado'          => $cart->total ?? $cartItem->subtotal ?? 0,
            'probabilidad'            => 10,
            'tipo_proyecto'           => 'residencial',
            'origen'                  => 'ecommerce',
            'tipo_oportunidad'        => 'producto',
            'requiere_visita_tecnica' => false,
            'cart_id'                 => $cart->id,
            'sede_id'                 => $prospecto->sede_id,
            'fecha_creacion'          => now(),
            'observaciones'           => "Oportunidad creada automáticamente. Primer producto agregado: {$nombreProducto}",
        ]);
    }

    /**
     * Actualiza el monto estimado de la oportunidad con el total actual del carrito.
     */
    private function actualizarOportunidad(Oportunidad $oportunidad, $cart): void
    {
        // Recalcular totales del carrito
        $cart->load('items');
        $nuevoTotal = $cart->items->sum('subtotal');

        $oportunidad->update([
            'monto_estimado' => $nuevoTotal,
        ]);
    }
}
