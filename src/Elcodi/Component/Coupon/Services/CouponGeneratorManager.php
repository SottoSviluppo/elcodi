<?php

namespace Elcodi\Component\Coupon\Services;

use DateTime;
use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Coupon\Exception\CouponAppliedException;
use Elcodi\Component\Coupon\Exception\CouponNotActiveException;
use Elcodi\Component\Coupon\Factory\CouponFactory;

class CouponGeneratorManager
{
    /**
     * @var CouponFactory
     *
     * Coupon Factory
     */
    private $couponFactory;

    /**
     * @var GeneratorInterface
     *
     * Coupon Code generator
     */
    private $couponCodeGenerator;

    /**
     * @var DateTimeFactory
     *
     * DateTime Factory
     */
    private $dateTimeFactory;

    private $couponRepository;
    private $couponDirector;
    private $couponCampaignManager;

    /**
     * Construct method.
     *
     * @param CouponFactory      $couponFactory       Coupon Factory
     * @param GeneratorInterface $couponCodeGenerator Generator
     * @param DateTimeFactory    $dateTimeFactory     DateTime Factory
     */
    public function __construct(
        CouponFactory $couponFactory,
        GeneratorInterface $couponCodeGenerator,
        DateTimeFactory $dateTimeFactory,
        $couponRepository,
        $couponDirector,
        $couponCampaignManager
    ) {
        $this->couponFactory = $couponFactory;
        $this->couponCodeGenerator = $couponCodeGenerator;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->couponRepository = $couponRepository;
        $this->couponDirector = $couponDirector;
        $this->couponCampaignManager = $couponCampaignManager;
    }

    private $count;
    private $couponCampaign;
    private $amount;
    private $chars;
    private $baseName;
    private $freeShipping;
    private $stackable;
    private $start;
    private $end;
    private $color;
    private $money;

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function setCouponCampaign($couponCampaign)
    {
        $this->couponCampaign = $couponCampaign;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setChars($chars)
    {
        $this->chars = $chars;
    }

    public function setBaseName($baseName)
    {
        $this->baseName = $baseName;
    }

    public function setFreeShipping($freeShipping)
    {
        $this->freeShipping = $freeShipping;
    }

    public function setStackable($stackable)
    {
        $this->stackable = $stackable;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function setMoney($money)
    {
        $this->money = $money;
    }

    public function generateCoupons($count, $money)
    {
        $coupons = array();
        for ($i = 0; $i < $count; $i++) {
            $coupon = $this->generateUniqueCoupon($money);
            $coupons[] = $coupon;
        }
        return $coupons;
    }

    public function generateUniqueCoupon($money)
    {
        $coupon = $this->getUniqueCoupon();

        $coupon->setCouponCampaign($this->couponCampaign);

        $coupon->setType(ElcodiCouponTypes::TYPE_AMOUNT);
        $coupon->setPrice($money);

        $coupon->setFreeShipping($this->freeShipping);
        $coupon->setStackable($this->stackable);
        $coupon->setColor($this->color);
        if ($this->start != null) {
            $coupon->setValidFrom(\DateTime::createFromFormat('Ymd', $this->start));
        }
        if ($this->end != null) {
            $coupon->setValidTo(\DateTime::createFromFormat('Ymd', $this->end));
        }
        $this->couponDirector->save($coupon);

        return $coupon;
    }

    private function getUniqueCoupon()
    {
        while (true) {
            $coupon = $this->generateBaseCoupon($this->baseName, $this->chars);
            $couponsWithCode = $this->couponRepository->findByCode($coupon->getCode());
            if (count($couponsWithCode) == 0) {
                break;
            }
            echo "doppio";
        }
        return $coupon;
    }

    public function generateBaseCoupon($name, $length)
    {
        $dateFrom = $this
            ->dateTimeFactory
            ->create();

        $dateTo = null;

        $couponGenerated = $this->couponFactory->create();
        $couponCode = $this
            ->couponCodeGenerator
            ->randomUpperString($length);

        $couponGenerated
            ->setCode($couponCode)
            ->setName($name . '_' . $couponCode)
            // ->setType($coupon->getType())
            // ->setPrice($coupon->getPrice())
            // ->setDiscount($coupon->getDiscount())
            ->setCount(1)
            // ->setPriority($coupon->getPriority())
            // ->setMinimumPurchase($coupon->getMinimumPurchase())
            ->setValidFrom($dateFrom)
            ->setValidTo($dateTo)
            // ->setValue($coupon->getValue())
            // ->setRule($coupon->getRule())
            // ->setEnforcement($coupon->getEnforcement())
            ->setEnabled(true);

        return $couponGenerated;
    }

}
