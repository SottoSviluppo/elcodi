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
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Wrapper\ShippingWrapper;

class CartShippingAmountLoader
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
     * @param CartInterface $cart Cart
     */
    public function loadCartShippingAmount(CartInterface $cart)
    {
        $shippingMethodId = $cart->getShippingMethod();

        if (empty($shippingMethodId)) {
            return;
        }

        $shippingMethod = $this
            ->shippingWrapper
            ->getOneById($cart, $shippingMethodId);

        if ($shippingMethod instanceof ShippingMethod) {
            $cart->setShippingAmount(
                $shippingMethod->getPrice()
            );
        }

        $this->applyFreeShippingCoupons($cart);
    }

    public function applyFreeShippingCoupons($cart)
    {
        // if coupon has freeshipping sets value to zero
        $cartCoupons = $this->cartCouponRepository->findByCart($cart);
        foreach ($cartCoupons as $cartCoupon) {
            $coupon = $cartCoupon->getCoupon();
            if ($coupon != null && $coupon->getFreeShipping()) {
                $zeroPrice = $this
                    ->emptyMoneyWrapper
                    ->get();

                $cart->setShippingAmount(
                    $zeroPrice
                );
            }
        }
    }
}
