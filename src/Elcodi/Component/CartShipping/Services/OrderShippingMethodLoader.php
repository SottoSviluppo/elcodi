<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\CartShipping\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Wrapper\ShippingWrapper;

class OrderShippingMethodLoader
{
    private $shippingWrapper;
    private $cartCouponRepository;
    private $emptyMoneyWrapper;

    public function __construct(ShippingWrapper $shippingWrapper, $cartCouponRepository, $emptyMoneyWrapper)
    {
        $this->shippingWrapper = $shippingWrapper;
        $this->cartCouponRepository = $cartCouponRepository;
        $this->emptyMoneyWrapper = $emptyMoneyWrapper;
    }

    /**
     * Performs all processes to be performed after the order creation.
     *
     * Flushes all loaded order and related entities.
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function loadOrderShippingMethod(
        CartInterface $cart,
        OrderInterface $order
    ) {
        $shippingMethodId = $cart->getShippingMethod();

        if (empty($shippingMethodId)) {
            return $this;
        }

        $shippingMethod = $this
            ->shippingWrapper
            ->getOneById($cart, $shippingMethodId);

        if ($shippingMethod instanceof ShippingMethod) {
            $order->setShippingAmount($shippingMethod->getPrice());
            $order->setShippingMethod($shippingMethod);
        }

        $this->applyFreeShippingCoupons($cart, $order);
    }

    private function applyFreeShippingCoupons($cart, $order)
    {
        // if coupon has freeshipping sets value to zero
        $cartCoupons = $this->cartCouponRepository->findByCart($cart);
        foreach ($cartCoupons as $cartCoupon) {
            $coupon = $cartCoupon->getCoupon();
            if ($coupon != null && $coupon->getFreeShipping()) {
                $zeroPrice = $this
                    ->emptyMoneyWrapper
                    ->get();

                $order->setShippingAmount(
                    $zeroPrice
                );
            }
        }
    }
}
