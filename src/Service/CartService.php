<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class CartService {
    private const KEY = '_cart';
    private $requestStack;

    public function __construct(RequestStack $requestStack) {
        $this->requestStack = $requestStack;
    }

    private function getSession() {
        return $this->requestStack->getSession();
    }

    public function getCart(): array {
        // Obtiene el carrito de la sesión, si no existe devuelve un array vacío
        return $this->getSession()->get(self::KEY, []);
    }

    public function add(int $id, int $quantity = 1) {
        $cart = $this->getCart();
        // Si el producto no está, lo añadimos con su cantidad
        if (!array_key_exists($id, $cart)) {
            $cart[$id] = $quantity;
        } else {
            // Opcional: Si ya existe, podrías sumar la cantidad
            $cart[$id] += $quantity;
        }
        $this->getSession()->set(self::KEY, $cart);
    }

    public function remove(int $id) {
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            $cart[$id]--;
            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }
        }
        $this->getSession()->set('_cart', $cart);
    }

    public function delete(int $id) {
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        $this->getSession()->set('_cart', $cart);
    }

    public function clear() {
        $this->getSession()->remove('_cart');
    }
}