<?php

namespace Elcodi\Component\Permission\Entity;

use Elcodi\Component\Permission\Entity\Abstracts\AbstractPermissionGroup;
use Exception;

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
    public function addPermission($entityType, $canRead, $canCreate, $canUpdate, $canDelete)
    {
        $permission = new Permission();
        $permission->setEntityType($entityType);
        $permission->setCanRead($canRead);
        $permission->setCanCreate($canCreate);
        $permission->setCanUpdate($canUpdate);
        $permission->setCanDelete($canDelete);

        if ($this->hasPermission($permission)) {
            throw new Exception("Permission already in collection");
        }

        $this->permissions->add($permission);

        return $this;
    }
}