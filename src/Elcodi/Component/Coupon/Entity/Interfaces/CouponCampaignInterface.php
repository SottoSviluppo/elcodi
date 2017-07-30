<?php

namespace Elcodi\Component\Coupon\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface CouponCampaignInterface.
 */
interface CouponCampaignInterface extends
IdentifiableInterface
, DateTimeInterface
{
    /**
     * Sets CampaignName.
     *
     * @param string $campaign_name CampaignName
     *
     * @return $this Self object
     */
    public function setCampaignName($campaign_name);

    /**
     * Get CampaignName.
     *
     * @return string CampaignName
     */
    public function getCampaignName();
}
