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

namespace Elcodi\Component\User\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface CustomerCategoryInterface.
 */
interface CustomerCategoryInterface extends
IdentifiableInterface,
DateTimeInterface,
EnabledInterface {
	/**
	 * Set id.
	 *
	 * @param string $id Id
	 *
	 * @return $this Self object
	 */
	public function setId($id);

	/**
	 * Get id.
	 *
	 * @return string Id
	 */
	public function getId();

	/**
	 * Set name.
	 *
	 * @param string $name Name
	 *
	 * @return $this Self object
	 */
	public function setName($name);

	/**
	 * Return name.
	 *
	 * @return string name
	 */
	public function getName();

	/**
	 * Get customers.
	 *
	 * @return Collection
	 */
	public function getCustomers();

	/**
     * Get categories.
	 *
	 * @return Collection
	 */
    public function getCategories();
}
