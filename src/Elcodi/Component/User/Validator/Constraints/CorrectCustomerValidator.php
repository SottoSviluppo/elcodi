<?php
namespace Elcodi\Component\User\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CorrectCustomerValidator extends ConstraintValidator
{
	public function validate($customer, Constraint $constraint)
	{
		if ($customer->isCompany())
		{
			if (strlen($customer->getCompanyName()) == 0 ||
				strlen($customer->getVat()) == 0 ||
				strlen($customer->getFiscalCode()) == 0)
			{
				$this->context->buildViolation($constraint->messageCompany)
				->atPath('foo')
				->addViolation();
			}
		}
		else
		{
			if (strlen($customer->getFirstname()) == 0 ||
				strlen($customer->getLastname()) == 0)
			{
				$this->context->buildViolation($constraint->messagePrivate)
				->atPath('foo')
				->addViolation();
			}
		}
	}
}