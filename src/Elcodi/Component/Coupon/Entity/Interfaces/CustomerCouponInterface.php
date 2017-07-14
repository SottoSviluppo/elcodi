<?php

namespace Elcodi\Component\Coupon\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface CustomerCouponInterface.
 */
interface CustomerCouponInterface extends IdentifiableInterface, DateTimeInterface
{

    /**
     * Sets Customer.
     *
     * @param string $customer Customer
     *
     * @return $this Self object
     */
    public function setCustomer($customer);

    /**
     * Get Customer.
     *
     * @return string Customer
     */
    public function getCustomer();

    /**
     * Sets Coupon.
     *
     * @param string $coupon Coupon
     *
     * @return $this Self object
     */
    public function setCoupon($coupon);

    /**
     * Get Coupon.
     *
     * @return string Coupon
     */
    public function getCoupon();

}
