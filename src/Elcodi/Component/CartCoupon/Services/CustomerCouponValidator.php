<?php

namespace Elcodi\Component\CartCoupon\Services;

use Elcodi\Component\CartCoupon\EventDispatcher\CartCouponEventDispatcher;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\CouponIncompatibleException;
use Elcodi\Component\Coupon\Services\CustomerCouponManager;

/**
 * Class CustomerCouponValidator.
 *
 * API methods:
 *
 * * validateCartCoupons(CartInterface)
 * * validateCoupon(CouponInterface)
 *
 * @api
 */
class CustomerCouponValidator
{
    /**
     * @var CartCouponManager
     *
     * CartCouponManager
     */
    // private $cartCouponManager;

    /**
     * @var CouponManager
     *
     * CouponManager
     */
    private $customerCouponManager;

    /**
     * @var CartCouponEventDispatcher
     *
     * CartCoupon Event Dispatcher
     */
    // private $cartCouponEventDispatcher;

    /**
     * Construct method.
     *
     * @param CartCouponManager         $cartCouponManager         Cart coupon manager
     * @param CouponManager             $customerCouponManager             Coupon Manager
     * @param CartCouponEventDispatcher $cartCouponEventDispatcher $cartCouponEventDispatcher
     */
    public function __construct(
        // CartCouponManager $cartCouponManager,
        CustomerCouponManager $customerCouponManager
        // CartCouponEventDispatcher $cartCouponEventDispatcher
    ) {
        // $this->cartCouponManager = $cartCouponManager;
        $this->customerCouponManager = $customerCouponManager;
        // $this->cartCouponEventDispatcher = $cartCouponEventDispatcher;
    }

    /**
     * Checks if all Coupons applied to current cart are still valid.
     * If are not, they will be deleted from the Cart and new Event typeof
     * CartCouponOnRejected will be dispatched.
     *
     * @param CartInterface $cart Cart
     */
    // public function validateCustomerCoupon(CartInterface $cart)
    // {
    //     $cartCoupons = $this
    //         ->cartCouponManager
    //         ->getCartCoupons($cart);

    //     foreach ($cartCoupons as $cartCoupon) {
    //         $coupon = $cartCoupon->getCoupon();

    //         try {
    //             $this
    //                 ->cartCouponEventDispatcher
    //                 ->dispatchCartCouponOnCheckEvent(
    //                     $cart,
    //                     $coupon
    //                 );
    //         } catch (AbstractCouponException $exception) {
    //             $this
    //                 ->cartCouponManager
    //                 ->removeCoupon(
    //                     $cart,
    //                     $coupon
    //                 );

    //             $this
    //                 ->cartCouponEventDispatcher
    //                 ->dispatchCartCouponOnRejectedEvent(
    //                     $cart,
    //                     $coupon
    //                 );
    //         }
    //     }
    // }

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
