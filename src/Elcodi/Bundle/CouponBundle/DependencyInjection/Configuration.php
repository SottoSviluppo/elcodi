<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\CouponBundle\DependencyInjection;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * Class Configuration.
 */
class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritdoc}
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('mapping')
            ->addDefaultsIfNotSet()
            ->children()
            ->append($this->addMappingNode(
                'coupon',
                'Elcodi\Component\Coupon\Entity\Coupon',
                '@ElcodiCouponBundle/Resources/config/doctrine/Coupon.orm.yml',
                'default',
                true
            ))
            ->append($this->addMappingNode(
                'coupon_campaign',
                'Elcodi\Component\Coupon\Entity\CouponCampaign',
                '@ElcodiCouponBundle/Resources/config/doctrine/CouponCampaign.orm.yml',
                'default',
                true
            ))
            ->append($this->addMappingNode(
                'customer_coupon',
                'Elcodi\Component\Coupon\Entity\CustomerCoupon',
                '@ElcodiCouponBundle/Resources/config/doctrine/CustomerCoupon.orm.yml',
                'default',
                true
            ))
            ->end()
            ->end()
            ->end();
    }
}
