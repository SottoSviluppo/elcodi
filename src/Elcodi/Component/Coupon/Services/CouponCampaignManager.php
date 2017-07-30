<?php

namespace Elcodi\Component\Coupon\Services;

use DateTime;
use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
use Elcodi\Component\Coupon\Exception\CouponAppliedException;
use Elcodi\Component\Coupon\Exception\CouponNotActiveException;
use Elcodi\Component\Coupon\Factory\CouponFactory;

class CouponCampaignManager
{
    private $couponCampaignFactory;
    private $couponCampaignRepository;
    private $couponCampaignDirector;

    public function __construct(
        $couponCampaignFactory,
        $couponCampaignRepository,
        $couponCampaignDirector
    ) {
        $this->couponCampaignFactory = $couponCampaignFactory;
        $this->couponCampaignRepository = $couponCampaignRepository;
        $this->couponCampaignDirector = $couponCampaignDirector;
    }

    public function getCouponCampaign($campaignName)
    {
        $couponCampaign = $this->couponCampaignRepository->findOneByCampaignName($campaignName);
        if ($couponCampaign === null) {
            $couponCampaign = $this->couponCampaignFactory->create();
            $couponCampaign->setCampaignName($campaignName);
            $this->couponCampaignDirector->save($couponCampaign);
        }
        return $couponCampaign;
    }

}
