<?php
namespace Elcodi\Component\User\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CorrectCustomer extends Constraint
{
	public $messageCompany = 'The company data are not complete.';
	public $messagePrivate = 'First name and last name are required.';

	public function getTargets()
	{
		return self::CLASS_CONSTRAINT;
	}
}