<?php

namespace Elcodi\Component\Permission\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;

/**
* Represents a permission group API
*/
interface AbstractPermissionGroupInterface
{
    /**
    * Get the associated user
    * @return AdminUserInterface
    */
    function getAdminUser();

    /**
    * Set the associated user
    * @param AdminUserInterface the user
    * @return $this Self object
    */
    function setAdminUser(AdminUserInterface $adminUser);

    /**
    * Get the group name
    * @return string
    */
    function getName();

    /**
    * Set the group name
    * @param string the group's name
    * @return $this Self object
    */
    function setName($name);

    /**
    * Get the list of permissions
    * @return Collection
    */
    function getPermissions();

    /**
    * Add a new permission
    * @param string the entity type
    * @param bool whether the user can read the entity
    * @param bool whether the user can create the entity
    * @param bool whether the user can update the entity
    * @param bool whether the user can delete the entity
    * @return $this Self object
    */
    function addPermission($entityType, $canRead, $canCreate, $canUpdate, $canDelete);

    /**
    * Remove the permission
    * @param AbstractPermissionInterface the permission to remove
    * @return $this Self object
    */
    function removePermission(AbstractPermissionInterface $permission);

    /**
    * Check whether the group contains the permission
    * @param AbstractPermissionInterface the permission to check
    * @return bool
    */
    function hasPermission(AbstractPermissionInterface $permission);
}
