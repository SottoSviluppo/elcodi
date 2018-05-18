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

namespace Elcodi\Component\CartCoupon\Applicator;

use Elcodi\Component\CartCoupon\Applicator\Interfaces\CartCouponApplicatorInterface;
use Elcodi\Component\CartCoupon\Services\PurchasableAmountCouponService;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 * Class PercentCartCouponApplicator.
 */
class PercentCartCouponApplicator implements CartCouponApplicatorInterface {

	/**
	 * @var CurrencyWrapper
	 *
	 * Currency Wrapper
	 */
	protected $currencyWrapper;
	/**
	 * @var PurchasableAmountCouponService
	 */
	private $purchasableAmountCouponService;

	/**
	 * Construct method.
	 *
	 * @param CurrencyWrapper   $currencyWrapper   Currency wrapper
	 * @param PurchasableAmountCouponService   $purchasableAmountCouponService
	 */
	public function __construct(
		CurrencyWrapper $currencyWrapper,
		$purchasableAmountCouponService
	) {
		$this->currencyWrapper = $currencyWrapper;
		$this->purchasableAmountCouponService = $purchasableAmountCouponService;
	}

	/**
	 * Get the id of the Applicator.
	 *
	 * @return string Applicator id
	 */
	public static function id() {
		return 2;
	}

	/**
	 * Can be applied.
	 *
	 * @param CartInterface   $cart   Cart
	 * @param CouponInterface $coupon Coupon
	 *
	 * @return bool Can be applied
	 */
	public function canBeApplied(
		CartInterface $cart,
		CouponInterface $coupon
	) {
		return $coupon->getType() === self::id();
	}

	/**
	 * Calculate coupon absolute value.
	 *
	 * @param CartInterface   $cart   Cart
	 * @param CouponInterface $coupon Coupon
	 *
	 * @return MoneyInterface|false Absolute value for this coupon in this cart.
	 */
	public function getCouponAbsoluteValue(
		CartInterface $cart,
		CouponInterface $coupon
	) {
		$couponCategoriesType = $coupon->getIncludeCategories();
		$couponPercent = $coupon->getDiscount();
		// Se il $couponCategoriesType è del tipo INCLUDE_CATEGORY oppure EXCLUDE_CATEGORY calcolo l'ammontare del carrello sul quale applicare lo sconto percentuale
		if ($couponCategoriesType == ElcodiCouponTypes::INCLUDE_CATEGORY || $couponCategoriesType == ElcodiCouponTypes::EXCLUDE_CATEGORY) {
			$purchasableAmount = $this->purchasableAmountCouponService->getPurchasableAmount($cart, $coupon);
		} elseif ($couponCategoriesType == null) {
			//il coupon non ha nessuna regola sulle categorie pertanto ammontare del carrello sul quale applicare il coupon è l'importo totale del carrello
			$purchasableAmount = $cart->getPurchasableAmount();
		}

		return $purchasableAmount->multiply($couponPercent / 100);
	}

}
