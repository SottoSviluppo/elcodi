<?php

namespace Elcodi\Component\Tax\Entity\Traits;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;

trait TaxAmountTrait
{
    /**
     * @var MoneyInterface
     *
     * amount for tax
     *
     */
    protected $taxAmount;

    /**
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
     *
     * Tax Currency
     */
    protected $taxCurrency;

    /**
     * Sets the Tax amount.
     *
     * @param MoneyInterface $taxAmount tax amount
     *
     * @return
     */
    public function setTaxAmount(MoneyInterface $taxAmount)
    {
        $this->taxAmount = $taxAmount->getAmount();
        $this->taxCurrency = $taxAmount->getCurrency();

        return $this;
    }

    /**
     * Gets the Tax taxAmount with tax.
     *
     * @return MoneyInterface Tax taxAmount
     */
    public function getTaxAmount()
    {
        return Money::create(
            $this->taxAmount,
            $this->taxCurrency
        );
    }

}
