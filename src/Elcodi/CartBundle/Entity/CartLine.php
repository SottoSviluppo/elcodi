<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\CartBundle\Entity;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Abstracts\AbstractLine;
use Elcodi\CartBundle\Resolver\DefaultPurchasableResolver;
use Elcodi\CartBundle\Resolver\Interfaces\PurchasableResolverInterface;

/**
 * Cart line
 */
class CartLine extends AbstractLine implements CartLineInterface
{
    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * Set Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartLine self Object
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Returns a purchasable resolver
     *
     * A purchasable resolver is needed so that classes in the
     * hierarchy can plug-in specific logic when adding a
     * Purchasable to an AbstractLine
     *
     * Here we will return teh Default resolver
     *
     * @return PurchasableResolverInterface
     */
    protected function getPurchasableResolver()
    {
        return new DefaultPurchasableResolver($this);
    }
}
