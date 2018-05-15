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

namespace Elcodi\Component\CartCoupon\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\CouponIncludeCategoriesException;
use Elcodi\Component\Currency\Services\CurrencyConverter;

/**
 * Class CartCouponIncludeExcludeCategoriesValidator.
 *
 * API methods:
 *
 * * validateCartCouponIncludeExclude(CartInterface, CouponInterface)
 *
 * @api
 */
class CartCouponIncludeExcludeCategoriesValidator {
	/**
	 * @var CurrencyConverter
	 *
	 * Currency converter
	 */
	private $currencyConverter;
	private $purchasableAmountCouponService;

	/**
	 * Construct.
	 *
	 * @param CurrencyConverter $currencyConverter
	 */
	public function __construct(CurrencyConverter $currencyConverter, PurchasableAmountCouponService $purchasableAmountCouponService) {
		$this->currencyConverter = $currencyConverter;
		$this->purchasableAmountCouponService = $purchasableAmountCouponService;
	}

	/**
	 * Check if cart meets minimum price requirements for a coupon.
	 *
	 * @param CartInterface   $cart   Cart
	 * @param CouponInterface $coupon Coupon
	 *
	 * @throws CouponIncludeCategoriesException Minimum value not reached
	 */
	public function validateCartCouponIncludeExclude(
		CartInterface $cart,
		CouponInterface $coupon
	) {
		$couponRuleCategories = $coupon->getIncludeCategories();

		//Se il coupon non ha settato nessun valore per inclusione/esclusione di categorie, prosegue
		if ($couponRuleCategories != ElcodiCouponTypes::INCLUDE_CATEGORY and $couponRuleCategories != ElcodiCouponTypes::EXCLUDE_CATEGORY) {
			return;
		}

		$couponCategories = $coupon->getCategories();

		$cartLines = $cart->getCartLines();

		$cartLineToAppliedCoupon = array();
		foreach ($cartLines as $line) {
			$purchasableCategories = $line->getPurchasable()->getCategories();

			$categoryFound = $this->getCartLinesOfCategories($purchasableCategories, $couponCategories);

			if ($categoryFound) {
				$cartLineToAppliedCoupon[] = $line;
			}

		}

		//se il tipo del coupon prevede l'inclusione di alcune categorie, verifico che nelle cartLines sia presente almeno un prodotto appartenente alle categorie selezionate nel coupon
		//verifico inoltre che l'importo dei prodotti delle categorie del coupon sia maggiore dell'ammontare del coupon stesso
		//altrimenti da l'eccezione che indica che il coupon non è applicabile
		if ($couponRuleCategories == ElcodiCouponTypes::INCLUDE_CATEGORY) {
			$amount = $coupon->getPrice();
			$purchasableAmount = $this->purchasableAmountCouponService->getPurchasableAmount($cart, $coupon);

			if (empty($cartLineToAppliedCoupon) or $purchasableAmount->isLessThan($amount)) {
				throw new CouponIncludeCategoriesException();
			}
		}

		return;
	}

	/**
	 * Controlla se almeno una delle categorie del prodotto coincide con una delle categorie del coupon
	 * @param  array $purchasableCategories categorie del prodotto
	 * @param  array $couponCategories     categorie del coupon
	 * @return bool
	 */
	private function getCartLinesOfCategories($purchasableCategories, $couponCategories) {

		foreach ($couponCategories as $couponCategory) {
			foreach ($purchasableCategories as $purchasableCategory) {
				if ($purchasableCategory->getId() == $couponCategory->getId()) {
					return true;
				}
			}
		}

		return false;

	}
}
