<?php

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\Coupon\EventDispatcher\CouponEventDispatcher;
use PaymentSuite\PaymentCoreBundle\Event\Abstracts\AbstractPaymentEvent;

class CouponUsageOnPaymentEventListener
{
    private $couponEventDispatcher;
    private $orderCouponRepository;

    public function __construct(CouponEventDispatcher $couponEventDispatcher, $orderCouponRepository)
    {
        $this->couponEventDispatcher = $couponEventDispatcher;
        $this->orderCouponRepository = $orderCouponRepository;
    }

    public function notifyCouponUsage(AbstractPaymentEvent $event)
    {
        $order = $event->getPaymentBridge()->getOrder();

        $orderCoupons = $this
            ->orderCouponRepository
            ->findOrderCouponsByOrder($order);

        foreach ($orderCoupons as $orderCoupon) {
            $coupon = $orderCoupon->getCoupon();
            $this
                ->couponEventDispatcher
                ->notifyCouponUsage($coupon);
        }
    }
}
