<?php

namespace Elcodi\Bundle\PermissionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

class ElcodiPermissionsExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_permissions';

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
            'elcodi.entity.permission.class' => $config['mapping']['permission']['class'],
            'elcodi.entity.permission.mapping_file' => $config['mapping']['permission']['mapping_file'],
            'elcodi.entity.permission.manager' => $config['mapping']['permission']['manager'],
            'elcodi.entity.permission.enabled' => $config['mapping']['permission']['enabled'],

            'elcodi.entity.permission_group.class' => $config['mapping']['permission_group']['class'],
            'elcodi.entity.permission_group.mapping_file' => $config['mapping']['permission_group']['mapping_file'],
            'elcodi.entity.permission_group.manager' => $config['mapping']['permission_group']['manager'],
            'elcodi.entity.permission_group.enabled' => $config['mapping']['permission_group']['enabled'],
        ];
    }

    /**
     * Config files to load.
     *
     * @param array $config Config
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            //'services',
            'factories',
            'repositories',
            'objectManagers',
            'directors'
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
            'Elcodi\Component\Permissions\Entity\Interfaces\AbstractPermissionInterface' => 'elcodi.entity.permission.class',
            'Elcodi\Component\Permissions\Entity\Interfaces\AbstractPermissionGroupInterface' => 'elcodi.entity.permission_group.class',
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