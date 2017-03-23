<?php

namespace Elcodi\Component\Cart\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;

class CartRestorer
{
    public $orderRepository;
    public $cartObjectManager;
    public $customerWrapper;

    public function __construct(
        $orderRepository,
        $cartObjectManager,
        $customerWrapper
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartObjectManager = $cartObjectManager;
        $this->customerWrapper = $customerWrapper;
    }

    public function restoreCartFromOrderId($id)
    {
        $this->setIfNotOrderedUseThisToFalse();
        $this->restoreOldCartFromOrderId($id);
    }

    private function setIfNotOrderedUseThisToFalse()
    {
        $customer = $this
            ->customerWrapper
            ->get();

        $customerCarts = $customer->getCarts();
        foreach ($customerCarts as $customerCart) {
            if ($customerCart->isIfNotOrderedUseThis()) {
                $customerCart->setIfNotOrderedUseThis(false);
                $this
                    ->cartObjectManager
                    ->flush($customerCart);
            }
        }
    }

    private function restoreOldCartFromOrderId($id)
    {
        $order = $this->orderRepository->find($id);

        $cart = $order->getCart();
        $cart->setOrdered(false);
        $cart->setIfNotOrderedUseThis(true);
        $this
            ->cartObjectManager
            ->flush($cart);
    }
}
