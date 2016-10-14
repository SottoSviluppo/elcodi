<?php

namespace Elcodi\Component\Permission\Entity\Abstracts;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\Component\Permission\Entity\Interfaces\AbstractPermissionGroupInterface;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Exception;

abstract class AbstractPermissionGroup implements AbstractPermissionGroupInterface
{
    use IdentifiableTrait;

    /**
    * @var string
    * The group name
    */
    protected $name;

    /**
    * @var AdminUserInterface
    * The associated user
    */
    protected $adminUser;

    /**
    * @var Collection
    * The list of permissions
    */
    protected $permissions;

    function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    /**
    * Get the associated user
    * @return AdminUserInterface
    */
    public function getAdminUser()
    {
        return $this->adminUser;
    }

    /**
    * Set the associated user
    * @param AdminUserInterface the user
    * @return $this Self object
    */
    public function setAdminUser(AdminUserInterface $adminUser)
    {
        $this->adminUser = $adminUser;
        return $this;
    }

    /**
    * Get the group name
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * Set the group name
    * @param string the group's name
    * @return $this Self object
    */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
    * Get the list of permissions
    * @return Collection
    */
    public function getPermissions()
    {
        return $this->permissions;
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
    public abstract function addPermission($entityType, $canRead, $canCreate, $canUpdate, $canDelete);

    /**
    * Remove the permission
    * @param AbstractPermissionInterface the permission to remove
    * @return $this Self object
    */
    public function removePermission(AbstractPermissionInterface $permission)
    {
        if (!$this->hasPermission($permission)) {
            throw new Exception("Item not found");
        }

        $this->permissions->removeElement($permission);
        return $this;
    }

    /**
    * Check whether the group contains the permission
    * @param AbstractPermissionInterface the permission to check
    * @return bool
    */
    public function hasPermission(AbstractPermissionInterface $permission)
    {
        if ($this->permissions->contains($permission)) {
            return true;
        }

        $exist = $this->permissions->exists(function($key, $element) use ($permission) {
            return (
                $permission->getEntityType() === $element->getEntityType() &&
                $permission->getCanRead() === $element->getCanRead() &&
                $permission->getCanCreate() === $element->getCanCreate() &&
                $permission->getCanUpdate() === $element->getCanUpdate() &&
                $permission->getCanDelete() === $element->getCanDelete()
            );
        });

        return $exist;
    }
}