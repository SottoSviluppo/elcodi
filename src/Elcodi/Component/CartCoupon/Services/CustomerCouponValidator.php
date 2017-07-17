<?php

namespace Elcodi\Component\CartCoupon\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\CouponIncompatibleException;
use Elcodi\Component\Coupon\Services\CustomerCouponManager;

/**
 * Class CustomerCouponValidator.
 *
 * API methods:
 *
 * * validateCustomerCoupon(CartInterface, CouponInterface)
 *
 * @api
 */
class CustomerCouponValidator
{

    /**
     * @var CustomerCouponManager
     *
     * CustomerCouponManager
     */
    private $customerCouponManager;

    /**
     * Construct method.
     *
     * @param CustomerCouponManager  $customerCouponManager
     */
    public function __construct(
        CustomerCouponManager $customerCouponManager
    ) {
        $this->customerCouponManager = $customerCouponManager;
    }

    /**
     * Check if cart meets basic requirements for a coupon.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @throws CouponIncompatibleException Coupon incompatible
     */
    public function validateCustomerCoupon(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        if ($cart->getTotalItemNumber() === 0) {
            throw new CouponIncompatibleException();
        }

        $customer = $cart->getCustomer();
        $this
            ->customerCouponManager
            ->checkCustomerCoupon($coupon, $customer);
    }
}
