<?php

namespace Elcodi\Component\CartCoupon\Services;

use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 *
 */
class PurchasableAmountCouponService {

	/**
	 * @var CurrencyWrapper
	 *
	 * Currency Wrapper
	 */
	protected $currencyWrapper;

	function __construct(CurrencyWrapper $currencyWrapper) {
		$this->currencyWrapper = $currencyWrapper;
	}

	private function calculatedPurchasableAmountForCouponCategories($purchasable, $couponCategories) {
		foreach ($couponCategories as $couponCategory) {
			foreach ($purchasable->getCategories() as $purchasableCategory) {
				if ($purchasableCategory->getId() == $couponCategory->getId()) {
					return $purchasable->getPrice();
				}
			}
		}

		return Money::create(0, $this->currencyWrapper->get());

	}

	public function getPurchasableAmount($cart, $coupon) {
		$cartLines = $cart->getCartLines();
		$purchasableAmount = $this->getInitialPurchasableAmount($coupon->getIncludeCategories(), $cart);

		foreach ($cartLines as $line) {

			$cartLineAmount = $this->calculatedPurchasableAmountForCouponCategories($line->getPurchasable(), $coupon->getCategories());
			if ($coupon->getIncludeCategories() == ElcodiCouponTypes::INCLUDE_CATEGORY) {
				$purchasableAmount = $purchasableAmount->add($cartLineAmount);
			} elseif ($coupon->getIncludeCategories() == ElcodiCouponTypes::EXCLUDE_CATEGORY) {
				$purchasableAmount = $purchasableAmount->subtract($cartLineAmount);
			}
		}

		return $purchasableAmount;
	}

	private function getInitialPurchasableAmount($couponCategoriesType, $cart) {
		if ($couponCategoriesType == ElcodiCouponTypes::INCLUDE_CATEGORY) {
			return Money::create(0, $this->currencyWrapper->get());
		}

		return $cart->getPurchasableAmount();

	}
}