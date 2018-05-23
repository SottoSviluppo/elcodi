<?php

namespace Elcodi\Component\User\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\User\Entity\Customer;
use Elcodi\Component\User\Entity\CustomerCategory;

/**
 * Class CustomerCategoryFactory.
 */
class CustomerCategoryFactory extends AbstractFactory {

	/**
	 * Creates an instance of an entity.
	 *
	 * This method must return always an empty instance
	 *
	 * @return CustomerCategory Empty entity
	 */
	public function create() {
		/**
		 * @var CustomerCategory $customerCategory
		 */
		$classNamespace = $this->getEntityNamespace();
		$customerCategory = new $classNamespace();
		$customerCategory
			->setEnabled(true)
			->setCreatedAt($this->now());

		return $customerCategory;
	}
}
