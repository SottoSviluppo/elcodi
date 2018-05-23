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

namespace Elcodi\Component\User\Entity;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\ExtraDataTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\User\Entity\Interfaces\CustomerCategoryInterface;

/**
 * Class CustomerCategory.
 */
class CustomerCategory implements CustomerCategoryInterface {
	use IdentifiableTrait,
	DateTimeTrait,
	EnabledTrait, ExtraDataTrait;

	/**
	 * @var string
	 *
	 * Category name
	 */
	protected $name;

	/**
	 * @var Collection
	 *
	 * Many-to-Many association between categories
	 * and products. The resulting collection could be huge.
	 */
	protected $customers;

	/**
	 * Set name.
	 *
	 * @param string $name Name
	 *
	 * @return $this Self object
	 */
	public function setName($name) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Return name.
	 *
	 * @return string name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Get customers.
	 *
	 * @return Collection
	 */
	public function getCustomers() {
		return $this->customers;
	}

	/**
	 * To string method.
	 *
	 * @return string
	 */
	public function __toString() {
		return (string) $this->getName();
	}
}
