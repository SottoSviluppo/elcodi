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

namespace Elcodi\Component\Coupon\Entity;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\ExtraDataTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Core\Entity\Traits\ValidIntervalTrait;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Product\Entity\Category;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class Coupon.
 */
class Coupon implements CouponInterface {
	use IdentifiableTrait,
	DateTimeTrait,
	EnabledTrait,
	ValidIntervalTrait, ExtraDataTrait;

	/**
	 * @var string
	 *
	 * Code
	 */
	protected $code;

	/**
	 * @var string
	 *
	 * Name
	 */
	protected $name;

	/**
	 * @var int
	 *
	 * Type
	 */
	protected $type;

	/**
	 * @var int
	 *
	 * Enforcement type
	 */
	protected $enforcement;

	/**
	 * @var int
	 *
	 * Price amount
	 */
	protected $priceAmount = 0;

	/**
	 * @var CurrencyInterface
	 *
	 * Price currency
	 */
	protected $priceCurrency;

	/**
	 * @var int
	 *
	 * Discount
	 */
	protected $discount = 0;

	/**
	 * @var int
	 *
	 * Absolute price amount
	 */
	protected $absolutePriceAmount = 0;

	/**
	 * @var CurrencyInterface
	 *
	 * Absolute price currency
	 */
	protected $absolutePriceCurrency;

	/**
	 * @var string
	 *
	 * Plain value
	 */
	protected $value;

	/**
	 * @var int
	 *
	 * Count
	 */
	protected $count;

	/**
	 * @var int
	 *
	 * Used times
	 */
	protected $used;

	/**
	 * @var int
	 *
	 * Priority
	 */
	protected $priority;

	/**
	 * @var int
	 *
	 * Minimum purchase amount
	 */
	protected $minimumPurchaseAmount;

	/**
	 * @var CurrencyInterface
	 *
	 * Minimum purchase currency
	 */
	protected $minimumPurchaseCurrency;

	/**
	 * @var int
	 *
	 * Whether this coupon can be used together with another coupon
	 */
	protected $stackable;

	/**
	 * @var RuleInterface
	 *
	 * Rule to check to be applicable
	 */
	protected $rule;

	/**
	 * @var string
	 *
	 * Color
	 */
	protected $color;

	/**
	 * @var bool
	 *
	 */
	protected $freeShipping;

	/**
	 * @var int number of coupon available for Customer
	 */
	protected $countCustomer = 0;

	/**
	 * @var entity
	 */
	protected $couponCampaign;

	/**
	 * @var int
	 */
	protected $includeCategories;

	/**
	 * @var entity
	 */
	protected $categories;

	/**
	 * Set code.
	 *
	 * @param string $code Code
	 *
	 * @return $this Self object
	 */
	public function setCode($code) {
		$this->code = $code;

		return $this;
	}

	/**
	 * Get code.
	 *
	 * @return string Code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * Set name coupon name.
	 *
	 * @param string $name
	 *
	 * @return $this Self object
	 */
	public function setName($name) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set type.
	 *
	 * @param int $type Type
	 *
	 * @return $this Self object
	 */
	public function setType($type) {
		$this->type = $type;

		return $this;
	}

	/**
	 * Get type.
	 *
	 * @return int Type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets Enforcement.
	 *
	 * @param int $enforcement Enforcement
	 *
	 * @return $this Self object
	 */
	public function setEnforcement($enforcement) {
		$this->enforcement = $enforcement;

		return $this;
	}

	/**
	 * Get Enforcement.
	 *
	 * @return int Enforcement
	 */
	public function getEnforcement() {
		return $this->enforcement;
	}

	/**
	 * Set price.
	 *
	 * @param MoneyInterface $amount Price
	 *
	 * @return $this Self object
	 */
	public function setPrice(MoneyInterface $amount) {
		$this->priceAmount = $amount->getAmount();
		$this->priceCurrency = $amount->getCurrency();

		return $this;
	}

	/**
	 * Get price.
	 *
	 * @return MoneyInterface Price
	 */
	public function getPrice() {
		return Money::create(
			$this->priceAmount,
			$this->priceCurrency
		);
	}

	/**
	 * Set discount.
	 *
	 * @param int $discount Discount
	 *
	 * @return $this Self object
	 */
	public function setDiscount($discount) {
		$this->discount = $discount;

		return $this;
	}

	/**
	 * Get discount.
	 *
	 * @return int discount
	 */
	public function getDiscount() {
		return $this->discount;
	}

	/**
	 * Set absolute price.
	 *
	 * @param MoneyInterface $amount Absolute Price
	 *
	 * @return $this Self object
	 */
	public function setAbsolutePrice(MoneyInterface $amount) {
		$this->absolutePriceAmount = $amount->getAmount();
		$this->absolutePriceCurrency = $amount->getCurrency();

		return $this;
	}

	/**
	 * Get absolute price.
	 *
	 * @return MoneyInterface Absolute Price
	 */
	public function getAbsolutePrice() {
		return Money::create(
			$this->absolutePriceAmount,
			$this->absolutePriceCurrency
		);
	}

	/**
	 * Get Value.
	 *
	 * @return string Value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Sets Value.
	 *
	 * @param string $value Value
	 *
	 * @return $this Self object
	 */
	public function setValue($value) {
		$this->value = $value;

		return $this;
	}

	/**
	 * Set count.
	 *
	 * @param int $count
	 *
	 * @return $this Self object
	 */
	public function setCount($count) {
		$this->count = $count;

		return $this;
	}

	/**
	 * Get count.
	 *
	 * @return int
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * Set used.
	 *
	 * @param int $used
	 *
	 * @return $this Self object
	 */
	public function setUsed($used) {
		$this->used = $used;

		return $this;
	}

	/**
	 * Get used.
	 *
	 * @return int Number this coupon has been used
	 */
	public function getUsed() {
		return $this->used;
	}

	/**
	 * Set priority.
	 *
	 * @param int $priority
	 *
	 * @return $this Self object
	 */
	public function setPriority($priority) {
		$this->priority = $priority;

		return $this;
	}

	/**
	 * Get priority.
	 *
	 * @return int Number this coupon has been priority
	 */
	public function getPriority() {
		return $this->priority;
	}

	/**
	 * Set minimum purchase.
	 *
	 * @param MoneyInterface $amount Absolute Price
	 *
	 * @return $this Self object
	 */
	public function setMinimumPurchase(MoneyInterface $amount) {
		$this->minimumPurchaseAmount = $amount->getAmount();
		$this->minimumPurchaseCurrency = $amount->getCurrency();

		return $this;
	}

	/**
	 * Get minimum purchase.
	 *
	 * @return MoneyInterface Absolute Price
	 */
	public function getMinimumPurchase() {
		return Money::create(
			$this->minimumPurchaseAmount,
			$this->minimumPurchaseCurrency
		);
	}

	/**
	 * Set rule Rule to check for applicability.
	 *
	 * @param RuleInterface $rule New rule
	 *
	 * @return $this Self object
	 */
	public function setRule(RuleInterface $rule = null) {
		$this->rule = $rule;

		return $this;
	}

	/**
	 * Get rule to check for applicability.
	 *
	 * @return RuleInterface Current rule
	 */
	public function getRule() {
		return $this->rule;
	}

	/**
	 * Get stackable property.
	 *
	 * @return int
	 */
	public function getStackable() {
		return $this->stackable;
	}

	/**
	 * Set stackable property.
	 *
	 * @param int $stackable
	 *
	 * @return $this Self object
	 */
	public function setStackable($stackable) {
		$this->stackable = $stackable;

		return $this;
	}

	/**
	 * Set color.
	 *
	 * @param string $color Color
	 *
	 * @return $this Self object
	 */
	public function setColor($color) {
		$this->color = $color;

		return $this;
	}

	/**
	 * Get color.
	 *
	 * @return string Color
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * Set freeShipping.
	 *
	 * @param string $freeShipping FreeShipping
	 *
	 * @return $this Self object
	 */
	public function setFreeShipping($freeShipping) {
		$this->freeShipping = $freeShipping;

		return $this;
	}

	/**
	 * Get freeShipping.
	 *
	 * @return string FreeShipping
	 */
	public function getFreeShipping() {
		return $this->freeShipping;
	}

	/**
	 * Set countCustomer.
	 *
	 * @param int $countCustomer
	 *
	 * @return $this Self object
	 */
	public function setCountCustomer($countCustomer) {
		$this->countCustomer = $countCustomer;

		return $this;
	}

	/**
	 * Get countCustomer.
	 *
	 * @return int
	 */
	public function getCountCustomer() {
		return $this->countCustomer;
	}

	/**
	 * Sets CouponCampaign.
	 *
	 * @param entity $couponCampaign
	 *
	 * @return $this Self object
	 */
	public function setCouponCampaign($couponCampaign) {
		$this->couponCampaign = $couponCampaign;

		return $this;
	}

	/**
	 * Get CouponCampaign.
	 *
	 * @return entity CouponCampaign
	 */
	public function getCouponCampaign() {
		return $this->couponCampaign;
	}

	/**
	 * Set includeCategories.
	 *
	 * @param int $includeCategories
	 *
	 * @return $this Self object
	 */
	public function setIncludeCategories($includeCategories) {
		$this->includeCategories = $includeCategories;

		return $this;
	}

	/**
	 * Get includeCategories.
	 *
	 * @return int
	 */
	public function getIncludeCategories() {
		return $this->includeCategories;
	}

	/**
	 * Get categories.
	 *
	 * @return Collection Categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Set categories.
	 *
	 * @param Collection $categories Categories
	 *
	 * @return $this Self object
	 */
	public function setCategories(Collection $categories) {
		$this->categories = $categories;

		return $this;
	}

	/**
	 * Add category.
	 *
	 * @param CategoryInterface $category Category
	 *
	 * @return $this Self object
	 */
	public function addCategory(Category $category) {
		if (!$this->categories->contains($category)) {
			$this
				->categories
				->add($category);
		}

		return $this;
	}

	/**
	 * Remove category.
	 *
	 * @param CategoryInterface $category Category
	 *
	 * @return $this Self object
	 */
	public function removeCategory(Category $category) {
		$this
			->categories
			->removeElement($category);

		return $this;
	}

	/**
	 * String representation of Coupon.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getName();
	}

	/**
	 * Increment used variable by one, and disables it if there are no more
	 * available units.
	 *
	 * @return $this Self object
	 */
	public function makeUse() {
		++$this->used;

		if ($this->count > 0 && $this->count <= $this->used) {
			$this->enabled = false;
		}

		return $this;
	}

}
