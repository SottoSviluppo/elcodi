<?php

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnCheckEvent;
use Elcodi\Component\CartCoupon\Services\CustomerCouponValidator;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;

/**
 * Class ValidateCustomerCouponEventListener.
 */
final class ValidateCustomerCouponEventListener
{
    /**
     * @var CustomerCouponValidator
     *
     * CartCoupon validator
     */
    private $customerCouponValidator;

    /**
     * Constructor.
     *
     * @param CustomerCouponValidator $customerCouponValidator CartCoupon validator
     */
    public function __construct(CustomerCouponValidator $customerCouponValidator)
    {
        $this->customerCouponValidator = $customerCouponValidator;
    }

    /**
     * Check if cart meets basic requirements for a coupon.
     *
     * @param CartCouponOnCheckEvent $event
     *
     * @throws AbstractCouponException
     */
    public function validateCustomerCoupon(CartCouponOnCheckEvent $event)
    {
        $this
            ->customerCouponValidator
            ->validateCustomerCoupon(
                $event->getCart(),
                $event->getCoupon()
            );
    }
}
