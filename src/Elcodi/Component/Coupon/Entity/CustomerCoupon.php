<?php

namespace Elcodi\Component\Coupon\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Coupon\Entity\Interfaces\CustomerCouponInterface;

/**
 * Class CustomerCoupon.
 */
class CustomerCoupon implements CustomerCouponInterface
{
    use IdentifiableTrait,
        DateTimeTrait
    ;

    /**
     * @var entity
     *
     */
    protected $customer;

    /**
     * @var entity
     *
     */
    protected $coupon;

    public function __construct()
    {
    }

    /**
     * Sets Customer.
     *
     * @param entity $customer
     *
     * @return $this Self object
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get Customer.
     *
     * @return entity Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Sets Coupon.
     *
     * @param entity $coupon
     *
     * @return $this Self object
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * Get Coupon.
     *
     * @return entity Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

}
