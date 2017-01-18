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
    * Set whether the user can view the store
    * @param bool whether the user can view the store
    * @return $this Self object
    */
    function setViewStore($viewStore);

    /**
    * Get whether the user can view the store
    * @return bool
    */
    function getViewStore();

    /**
    * Set whether the user can view the shipping admin area
    * @param bool whether the user can view the shipping area
    * @return $this Self object
    */
    function setViewShipping($viewShipping);

    /**
    * Get whether the user can view the shipping admin area
    * @return bool
    */
    function getViewShipping();

    /**
    * Set whether the user can view the app store
    * @param bool whether the user can view the app store
    * @return $this Self object
    */
    function setViewAppStore($viewAppStore);

    /**
    * Get whether the user can view the app store
    * @return bool
    */
    function getViewAppStore();

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
