<?php

namespace Elcodi\Component\Coupon\Factory;

use Elcodi\Component\Coupon\Entity\CustomerCoupon;
use Elcodi\Component\Coupon\Entity\Interfaces\CustomerCouponInterface;
use Elcodi\Component\Currency\Factory\Abstracts\AbstractPurchasableFactory;

/**
 * Class CustomerCouponFactory.
 */
class CustomerCouponFactory extends AbstractPurchasableFactory
{
    /**
     * Creates an instance of a simple customerCoupon.
     *
     * This method must return always an empty instance for related entity
     *
     * @return CustomerCoupon Empty entity
     */
    public function create()
    {
        $now = $this->now();
        $zeroPrice = $this->createZeroAmountMoney();

        /**
         * @var CustomerCouponInterface $customerCoupon
         */
        $classNamespace = $this->getEntityNamespace();
        $customerCoupon = new $classNamespace();
        $customerCoupon
            ->setCreatedAt($now);

        return $customerCoupon;
    }
}
