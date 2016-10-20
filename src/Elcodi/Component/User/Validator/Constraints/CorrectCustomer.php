<?php
namespace Elcodi\Component\User\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CorrectCustomer extends Constraint
{
    public $messageCompany = 'customer.error.company_data_not_complete';
    public $messagePrivate = 'customer.error.first_last_required';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
