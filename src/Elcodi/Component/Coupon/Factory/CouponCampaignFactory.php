<?php

namespace Elcodi\Component\Coupon\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

class CouponCampaignFactory extends AbstractFactory
{
    public function create()
    {
        $classNamespace = $this->getEntityNamespace();
        $element = new $classNamespace();
        $element

            ->setCreatedAt($this->now())
            ->setUpdatedAt($this->now())
        ;

        return $element;
    }
}
