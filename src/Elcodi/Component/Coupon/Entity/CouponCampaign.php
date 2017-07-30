<?php

namespace Elcodi\Component\Coupon\Entity;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponCampaignInterface;

/**
 * Class CouponCampaign.
 */
class CouponCampaign implements CouponCampaignInterface
{
    use IdentifiableTrait
    , DateTimeTrait
    ;

    /**
     * @var string
     */
    protected $campaignName;

    public function __construct()
    {
    }

    /**
     * Sets CampaignName.
     *
     * @param string $campaignName
     *
     * @return $this Self object
     */
    public function setCampaignName($campaignName)
    {
        $this->campaignName = $campaignName;

        return $this;
    }

    /**
     * Get CampaignName.
     *
     * @return string CampaignName
     */
    public function getCampaignName()
    {
        return $this->campaignName;
    }

    public function __toString()
    {
        return $this->campaignName;
    }
}
