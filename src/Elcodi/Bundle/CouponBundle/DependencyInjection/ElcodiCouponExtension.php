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

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that loads and manages your bundle configuration.
 */
class ElcodiCouponExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_coupon';

    /**
     * Get the Config file location.
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * Return a new Configuration instance.
     *
     * If object returned by this method is an instance of
     * ConfigurationInterface, extension will use the Configuration to read all
     * bundle config definitions.
     *
     * Also will call getParametrizationValues method to load some config values
     * to internal parameters.
     *
     * @return ConfigurationInterface Configuration file
     */
    protected function getConfigurationInstance()
    {
        return new Configuration(static::EXTENSION_NAME);
    }

    /**
     * Load Parametrization definition.
     *
     * return array(
     *      'parameter1' => $config['parameter1'],
     *      'parameter2' => $config['parameter2'],
     *      ...
     * );
     *
     * @param array $config Bundles config values
     *
     * @return array Parametrization values
     */
    protected function getParametrizationValues(array $config)
    {
        return [
            'elcodi.entity.coupon.class' => $config['mapping']['coupon']['class'],
            'elcodi.entity.coupon.mapping_file' => $config['mapping']['coupon']['mapping_file'],
            'elcodi.entity.coupon.manager' => $config['mapping']['coupon']['manager'],
            'elcodi.entity.coupon.enabled' => $config['mapping']['coupon']['enabled'],
            'elcodi.entity.coupon_campaign.class' => $config['mapping']['coupon_campaign']['class'],
            'elcodi.entity.coupon_campaign.mapping_file' => $config['mapping']['coupon_campaign']['mapping_file'],
            'elcodi.entity.coupon_campaign.manager' => $config['mapping']['coupon_campaign']['manager'],
            'elcodi.entity.coupon_campaign.enabled' => $config['mapping']['coupon_campaign']['enabled'],
            'elcodi.entity.customer_coupon.class' => $config['mapping']['customer_coupon']['class'],
            'elcodi.entity.customer_coupon.mapping_file' => $config['mapping']['customer_coupon']['mapping_file'],
            'elcodi.entity.customer_coupon.manager' => $config['mapping']['customer_coupon']['manager'],
            'elcodi.entity.customer_coupon.enabled' => $config['mapping']['customer_coupon']['enabled'],
        ];
    }

    /**
     * Config files to load.
     *
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'commands',
            'services',
            'factories',
            'eventDispatchers',
            'eventListeners',
            'repositories',
            'objectManagers',
            'directors',
        ];
    }

    /**
     * Get entities overrides.
     *
     * Result must be an array with:
     * index: Original Interface
     * value: Parameter where class is defined.
     *
     * @return array Overrides definition
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\Coupon\Entity\Interfaces\CouponCampaignInterface' => 'elcodi.entity.coupon_campaign.class',
            'Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface' => 'elcodi.entity.coupon.class',
        ];
    }

    /**
     * Returns the extension alias, same value as extension name.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }
}
