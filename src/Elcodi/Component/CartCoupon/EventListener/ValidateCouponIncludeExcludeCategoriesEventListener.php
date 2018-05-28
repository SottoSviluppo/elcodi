<?php

namespace Elcodi\Component\CartCoupon\EventListener;

use Elcodi\Component\CartCoupon\Event\CartCouponOnApplyEvent;
use Elcodi\Component\CartCoupon\Services\CartCouponIncludeExcludeCategoriesValidator;

/**
 * Class ValidateCouponIncludeExcludeCategoriesEventListener.
 */
final class ValidateCouponIncludeExcludeCategoriesEventListener {
	/**
	 * @var CartCouponIncludeExcludeCategoriesValidator
	 *
	 * CartCoupon minimum price validator
	 */
	private $cartCouponIncludeExcludeCategoriesValidator;

	/**
	 * Construct.
	 *
	 * @param CartCouponIncludeExcludeCategoriesValidator $cartCouponIncludeExcludeCategoriesValidator CartCoupon minimum price validator
	 */
	public function __construct(CartCouponIncludeExcludeCategoriesValidator $cartCouponIncludeExcludeCategoriesValidator) {
		$this->cartCouponIncludeExcludeCategoriesValidator = $cartCouponIncludeExcludeCategoriesValidator;
	}

	/**
	 * Check if cart meets minimum price requirements for a coupon.
	 *
	 * @param CartCouponOnApplyEvent $event Event
	 */
	public function validateCartCouponIncludeExclude(CartCouponOnApplyEvent $event) {
		$this
			->cartCouponIncludeExcludeCategoriesValidator
			->validateCartCouponIncludeExclude(
				$event->getCart(),
				$event->getCoupon()
			);
	}
}
