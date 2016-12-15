<?php

namespace Elcodi\Component\Permissions\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
* Represents a permission group API
*/
interface AbstractPermissionGroupInterface extends IdentifiableInterface
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
    * Set the list of permissions
    * @param Collection the list of permissions
    * @return $this Self object
    */
    function setPermissions(Collection $permissions);

    /**
    * Get the list of permissions
    * @return Collection
    */
    function getPermissions();

    /**
    * Add a new permission
    * @param AbstractPermissionInterface the permission to add
    * @return $this Self object
    */
    function addPermission(AbstractPermissionInterface $permission);

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
