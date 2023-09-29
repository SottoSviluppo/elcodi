<?php

namespace Elcodi\Component\CartCoupon\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\CouponCustomerCategoriesException;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class CartCouponCustomerCategoriesValidator.
 *
 * API methods:
 *
 * * validateCartCouponCustomer(CartInterface, CouponInterface)
 *
 * @api
 */
class CartCouponCustomerCategoriesValidator {

	private $securityTokenStorage;
	private $customerCategoryService;

	/**
	 * Construct.
	 *
	 * @param CurrencyConverter $currencyConverter
	 */
	public function __construct($securityTokenStorage, $customerCategoryService) {
		$this->securityTokenStorage = $securityTokenStorage;
		$this->customerCategoryService = $customerCategoryService;
	}

	/**
	 * Check if cart meets minimum price requirements for a coupon.
	 *
	 * @param CartInterface   $cart   Cart
	 * @param CouponInterface $coupon Coupon
	 *
	 * @throws CouponCustomerCategoriesException Minimum value not reached
	 */
	public function validateCartCouponCustomer(
		CartInterface $cart,
		CouponInterface $coupon
	) {
		$couponCustomerCategories = $coupon->getCustomerCategories();

		//Se il coupon non ha selezionato nessuna categoria di utenti prosegue
		if (count($couponCustomerCategories) == 0) {
			return;
		}

        if($this->securityTokenStorage->getToken()) {
            $loggedCustomer = $this->securityTokenStorage->getToken()->getUser();

            if ($loggedCustomer instanceof CustomerInterface) {
                $categoriesLoggedCustomer = $loggedCustomer->getCustomerCategories();

                $haveCustomerCategory = $this->customerCategoryService->haveCustomerCategories($loggedCustomer, $categoriesLoggedCustomer, $couponCustomerCategories);
                if (!$haveCustomerCategory) {
                    throw new CouponCustomerCategoriesException();
                }

            }
        }

		return;

	}

}
