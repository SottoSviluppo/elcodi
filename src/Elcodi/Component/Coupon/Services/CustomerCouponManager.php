<?php

namespace Elcodi\Component\Coupon\Services;

use DateTime;
use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Coupon\Exception\CouponAppliedException;
use Elcodi\Component\Coupon\Repository\CustomerCouponRepository;
use Elcodi\Component\User\Entity\Customer;

/**
 * Coupon manager service.
 *
 * Manages all coupon actions
 */
class CustomerCouponManager
{
    /**
     * @var CustomerCouponRepository
     *
     * CustomerCoupon Repository
     */
    private $customerCouponRepository;

    /**
     * Construct method.
     *
     * @param CustomerCouponRepository      $customerCouponRepository       Coupon Factory
     * @param DateTimeFactory    $dateTimeFactory     DateTime Factory
     */
    public function __construct(
        CustomerCouponRepository $customerCouponRepository
    ) {
        $this->customerCouponRepository = $customerCouponRepository;
    }

    /**
     * Checks whether a coupon can be applied or not.
     *
     * @param CouponInterface $coupon Coupon to work with
     * @param CustomerInterface $customer
     *
     * @return bool Coupon can be applied
     *
     * @throws AbstractCouponException
     */
    public function checkCustomerCoupon(CouponInterface $coupon, Customer $customer)
    {

        if (!$this->canBeUsed($coupon, $customer)) {
            throw new CouponAppliedException();
        }

        return true;
    }

    /**
     * Check if a coupon can be currently used.
     *
     * @param CouponInterface $coupon
     * @param CustomerInterface $customer
     *
     * @return bool
     */
    private function canBeUsed(CouponInterface $coupon, Customer $customer)
    {
        $countCustomer = $coupon->getCountCustomer();

        if ($countCustomer === 0) {
            return true;
        }

        $couponCustomerUsed = $this->customerCouponRepository->findBy(array('customer' => $customer, 'coupon' => $coupon));

        if (count($couponCustomerUsed) < $countCustomer) {
            return true;
        }

        return false;
    }
}
