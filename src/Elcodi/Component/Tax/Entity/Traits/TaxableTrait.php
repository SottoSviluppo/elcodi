<?php

namespace Elcodi\Component\Tax\Entity\Traits;

use Elcodi\Component\Tax\Entity\Interfaces\TaxInterface;

trait TaxableTrait
{
    /**
     * @var \Elcodi\Component\Tax\Entity\Interfaces\TaxInterface
     */
    protected $tax;

    public function getTax()
    {
        return $this->tax;
    }

    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }
}
