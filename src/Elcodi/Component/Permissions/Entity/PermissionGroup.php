<?php

namespace Elcodi\Component\Permissions\Entity;

use Elcodi\Component\Permissions\Entity\Abstracts\AbstractPermissionGroup;
use Exception;
use InvalidArgumentException;

class PermissionGroup extends AbstractPermissionGroup
{
    function __construct()
    {
        parent::__construct();
    }

    /**
    * Add a new permission
    * @param string the entity type
    * @param bool whether the user can read the entity
    * @param bool whether the user can create the entity
    * @param bool whether the user can update the entity
    * @param bool whether the user can delete the entity
    * @return $this Self object
    */
    public function addPermission($resource, $canRead, $canCreate, $canUpdate, $canDelete)
    {
        $permission = new Permission();
        $permission->setResource($resource)
            ->setCanRead($canRead)
            ->setCanCreate($canCreate)
            ->setCanUpdate($canUpdate)
            ->setCanDelete($canDelete);

        if ($this->hasPermission($permission)) {
            throw new Exception("Permission already in collection");
        }

        $this->permissions->add($permission);

        return $this;
    }
}