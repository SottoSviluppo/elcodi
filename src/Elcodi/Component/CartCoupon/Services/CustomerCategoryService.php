<?php

namespace Elcodi\Component\CartCoupon\Services;

/**
 *
 */
class CustomerCategoryService {

	function __construct() {
		# code...
	}

	/**
	 * Controlla se almeno una delle categorie del cliente coincide con una delle categorie del coupon
	 * @param  array $customer cliente
	 * @param  array $categoriesLoggedCustomer  categorie del cliente loggato
	 * @param  array $$couponCustomerCategories  categorie del coupon
	 * @return bool
	 */
	public function haveCustomerCategories($customer, $categoriesLoggedCustomer, $couponCustomerCategories) {

		foreach ($couponCustomerCategories as $couponCategory) {
			foreach ($categoriesLoggedCustomer as $customerCategory) {
				if ($customerCategory->getId() == $couponCategory->getId()) {
					return true;
				}
			}
		}

		return false;

	}
}