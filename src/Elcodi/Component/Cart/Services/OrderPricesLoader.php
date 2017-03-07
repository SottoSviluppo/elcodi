<?php

namespace Elcodi\Component\Cart\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;

class OrderPricesLoader
{
    private $currencyWrapper;
    private $currencyConverter;

    public function __construct(
        WrapperInterface $currencyWrapper,
        CurrencyConverter $currencyConverter
    ) {
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    public function getOrderAmountWithShippingAndCoupon($order)
    {
        $currency = $this
            ->currencyWrapper
            ->get();

        $finalAmount = $this->getOrderAmountWithShipping($order);

        /**
         * Calculates the coupon amount.
         */
        $couponAmount = $order->getCouponAmount();
        if ($couponAmount instanceof MoneyInterface) {
            $convertedCouponAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $couponAmount,
                    $currency
                );
            $finalAmount = $finalAmount->subtract($convertedCouponAmount);
        }
        return $finalAmount;
    }

    public function getOrderAmountWithShipping($order)
    {
        $currency = $this
            ->currencyWrapper
            ->get();

        $finalAmount = clone $order->getPurchasableAmount();

        /**
         * Calculates the shipping amount.
         */
        $shippingAmount = $order->getShippingAmount();
        if ($shippingAmount instanceof MoneyInterface) {
            $convertedShippingAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $shippingAmount,
                    $currency
                );
            $finalAmount = $finalAmount->add($convertedShippingAmount);
        }

        return $finalAmount;
    }

}
