<?php

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Services\CartCouponCustomerCategoriesValidator;

/**
 * Class ValidateCouponCustomerCategoriesEventListener.
 */
final class ValidateCouponCustomerCategoriesEventListener {
	/**
	 * @var CartCouponCustomerCategoriesValidator
	 *
	 * CartCoupon minimum price validator
	 */
	private $cartCouponCustomerCategoriesValidator;

	/**
	 * Construct.
	 *
	 * @param CartCouponCustomerCategoriesValidator $cartCouponCustomerCategoriesValidator CartCoupon minimum price validator
	 */
	public function __construct(CartCouponCustomerCategoriesValidator $cartCouponCustomerCategoriesValidator) {
		$this->cartCouponCustomerCategoriesValidator = $cartCouponCustomerCategoriesValidator;
	}

	/**
	 * Check if cart meets minimum price requirements for a coupon.
	 *
	 * @param CartCouponOnApplyEvent $event Event
	 */
	public function validateCartCouponCustomer(CartCouponOnApplyEvent $event) {

		$this
			->cartCouponCustomerCategoriesValidator
			->validateCartCouponCustomer(
				$event->getCart(),
				$event->getCoupon()
			);
	}
}
