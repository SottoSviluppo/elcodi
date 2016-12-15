<?php

namespace Elcodi\Component\Permissions\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Permissions\Entity\PermissionGroup;

class PermissionGroupFactory extends AbstractFactory
{
    /**
    * Create an instance of permission group
    * @return PermissionGroup new permission group
    */
    public function create()
    {
        $classNamespace = $this->getEntityNamespace();
        $permissionGroup = new $classNamespace();

        return $permissionGroup;
    }
}