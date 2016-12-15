<?php

namespace Elcodi\Bundle\PermissionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

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
                            'permission',
                            'Elcodi\Component\Permissions\Entity\Permission',
                            '@ElcodiPermissionsBundle/Resources/config/doctrine/Permission.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'permission_group',
                            'Elcodi\Component\Permissions\Entity\PermissionGroup',
                            '@ElcodiPermissionsBundle/Resources/config/doctrine/PermissionGroup.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
            ->end();
    }
}