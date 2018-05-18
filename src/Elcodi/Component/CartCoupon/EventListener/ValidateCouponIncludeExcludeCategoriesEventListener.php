<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

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
