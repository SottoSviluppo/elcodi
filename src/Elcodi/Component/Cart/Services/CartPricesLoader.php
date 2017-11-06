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

namespace Elcodi\Component\Cart\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;

/**
 * Class CartPricesLoader.
 *
 * Api Methods:
 *
 * * loadCartPurchasablesAmount(CartInterface)
 * * loadCartTotalAmount(CartInterface)
 *
 * @api
 */
class CartPricesLoader
{
    /**
     * @var WrapperInterface
     *
     * Currency Wrapper
     */
    protected $currencyWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency Converter
     */
    protected $currencyConverter;

    /**
     * Built method.
     *
     * @param WrapperInterface  $currencyWrapper   Currency Wrapper
     * @param CurrencyConverter $currencyConverter Currency Converter
     */
    public function __construct(
        WrapperInterface $currencyWrapper,
        CurrencyConverter $currencyConverter
    ) {
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Load cart purchasables prices.
     *
     * @param CartInterface $cart Cart
     */
    public function loadCartPurchasablesAmount(CartInterface $cart)
    {
        $currency = $this
            ->currencyWrapper
            ->get();

        $purchasableAmount = Money::create(0, $currency);

        /**
         * Calculate Amount and PurchasableAmount.
         */
        foreach ($cart->getCartLines() as $cartLine) {

            /**
             * @var CartLineInterface $cartLine
             */
            $cartLine = $this->loadCartLinePrices($cartLine);

            /**
             * @var MoneyInterface $purchasableAmount
             * @var MoneyInterface $totalAmount
             */
            $convertedPurchasableAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $cartLine->getPurchasableAmount(),
                    $currency
                );

            $purchasableAmount = $purchasableAmount
                ->add($convertedPurchasableAmount->multiply(
                    $cartLine->getQuantity()
                ));
        }

        $cart->setPurchasableAmount($purchasableAmount);
    }

    /**
     * Load cart total price.
     *
     * @param CartInterface $cart Cart
     */
    public function loadCartTotalAmount(CartInterface $cart)
    {
        $currency = $this
            ->currencyWrapper
            ->get();

        $finalAmount = clone $cart->getPurchasableAmount();

        /**
         * Calculates the shipping amount.
         */
        $shippingAmount = $cart->getShippingAmount();
        if ($shippingAmount instanceof MoneyInterface) {
            $convertedShippingAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $shippingAmount,
                    $currency
                );
            $finalAmount = $finalAmount->add($convertedShippingAmount);
        }

        /**
         * Calculates the coupon amount.
         */
        $couponAmount = $cart->getCouponAmount();
        if ($couponAmount instanceof MoneyInterface) {
            $convertedCouponAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $couponAmount,
                    $currency
                );
            $finalAmount = $finalAmount->subtract($convertedCouponAmount);
        }

        $cart->setAmount($finalAmount);
    }

    /**
     * Loads CartLine prices.
     * This method does not consider Coupon.
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartLineInterface Line with prices loaded
     */
    protected function loadCartLinePrices(CartLineInterface $cartLine)
    {
        $purchasable = $cartLine->getPurchasable();
        if ($purchasable->getKeepCartPrice()) {
            return $cartLine;
        }

        $purchasablePrice = $purchasable->getPrice();

        /**
         * If present, reducedPrice will be used as purchasable price in current CartLine.
         */
        if ($purchasable->getReducedPrice()->getAmount() > 0) {
            $purchasablePrice = $purchasable->getReducedPrice();
        }

        /**
         * Setting amounts for current CartLine.
         *
         * Line Currency was set by CartManager::addPurchasable when factorizing CartLine
         */
        $cartLine->setPurchasableAmount($purchasablePrice);
        $cartLine->setAmount($purchasablePrice->multiply($cartLine->getQuantity()));

        return $cartLine;
    }

    public function getTaxAmount(CartInterface $cart)
    {
        $taxAmount = 0;
        foreach ($cart->getCartLines() as $cartLine) {
            if ($cartLine->getTax() === null) {
                continue;
            }

            $tax = $cartLine->getTax()->getValue();
            $purchasablePrice = $cartLine->getPurchasable()->getPrice()->getAmount();
            $cartLineTaxAmount = $purchasablePrice * $tax / 100;
            $taxAmount += $cartLineTaxAmount;
        }
        $taxAmountMoney = \Elcodi\Component\Currency\Entity\Money::create(
            $taxAmount,
            $cart->getAmount()->getCurrency()
        );

        return $taxAmountMoney;
    }
}
