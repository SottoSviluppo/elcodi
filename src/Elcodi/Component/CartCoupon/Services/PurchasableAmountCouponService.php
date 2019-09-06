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
	private $store;

	function __construct(CurrencyWrapper $currencyWrapper, $store) {
		$this->currencyWrapper = $currencyWrapper;
		$this->store = $store;
	}

	private function calculatedPurchasableAmountForCouponCategories($cartLine, $couponCategories) {
		$purchasable = $cartLine->getPurchasable();
		foreach ($couponCategories as $couponCategory) {
			foreach ($purchasable->getCategories() as $purchasableCategory) {
				//prezzo per la quantità
				$purchasablePrice = $purchasable->getPrice();
				$purchasableAmount = $purchasablePrice->multiply($cartLine->getQuantity());

				//controllo se i prezzi sono comprensivi di tasse, se non lo sono applico l'iva
				if (!$this->store->getTaxIncluded()) {
					$tax = $purchasable->getTax()->getValue();
					$taxAmount = $purchasableAmount->getAmount() * $tax / 100;
					$purchasableMoneyTax = \Elcodi\Component\Currency\Entity\Money::create(
						$taxAmount,
						$cartLine->getAmount()->getCurrency()
					);
					$purchasableAmount = $purchasableAmount->add($purchasableMoneyTax);
				}

				if ($purchasableCategory->getParent() != null) {
					$purchasableParentCategoryId = $purchasableCategory->getParent()->getId();
					if ($purchasableCategory->getId() == $couponCategory->getId() || $purchasableParentCategoryId == $couponCategory->getId()) {
						return $purchasableAmount;
					}
				} else {
					if ($purchasableCategory->getId() == $couponCategory->getId()) {
						return $purchasableAmount;
					}
				}
			}
		}

		return Money::create(0, $this->currencyWrapper->get());

	}

	public function getPurchasableAmount($cart, $coupon) {
		$cartLines = $cart->getCartLines();
		$purchasableAmount = $this->getInitialPurchasableAmount($coupon->getIncludeCategories(), $cart);
		foreach ($cartLines as $line) {

			$cartLineAmount = $this->calculatedPurchasableAmountForCouponCategories($line, $coupon->getCategories());
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

		if (!$this->store->getTaxIncluded()) {
			//se i prodotti hanno i prezzi iva esclusa prima di applicare lo sconto va applicata l'iva
			$purchasableAmount = $cart->getPurchasableAmount();
			$cartAmount = $purchasableAmount->add($cart->getTaxAmount());
			return $cartAmount;
		}

		return $cart->getPurchasableAmount();

	}
}