<?php

namespace Elcodi\Component\Permissions\Entity\Abstracts;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Elcodi\Component\Permissions\Entity\Interfaces\AbstractPermissionGroupInterface;
use Elcodi\Component\Permissions\Entity\Interfaces\AbstractPermissionInterface;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;

use Exception;
use InvalidArgumentException;

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

    /**
    * @var bool
    * Whether the user can view the store menu item
    */
    protected $viewStore;

    /**
    * @var bool
    * Whether the user can view the shipping menu item
    */
    protected $viewShipping;

    /**
    * @var bool
    * Whether the user can view the app store menu item
    */
    protected $viewAppStore;

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
        if ($adminUser == null) {
            throw new InvalidArgumentException('adminUser');
        }

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
    * Set whether the user can view the store
    * @param bool whether the user can view the store
    * @return $this Self object
    */
    public function setViewStore($viewStore)
    {
        $this->viewStore = $viewStore;
        return $this;
    }

    /**
    * Get whether the user can view the store
    * @return bool
    */
    public function getViewStore()
    {
        return $this->viewStore;
    }

    /**
    * Set whether the user can view the shipping admin area
    * @param bool whether the user can view the shipping area
    * @return $this Self object
    */
    public function setViewShipping($viewShipping)
    {
        $this->viewShipping = $viewShipping;
        return $this;
    }

    /**
    * Get whether the user can view the shipping admin area
    * @return bool
    */
    public function getViewShipping()
    {
        return $this->viewShipping;
    }

    /**
    * Set whether the user can view the app store
    * @param bool whether the user can view the app store
    * @return $this Self object
    */
    public function setViewAppStore($viewAppStore)
    {
        $this->viewAppStore = $viewAppStore;
        return $this;
    }

    /**
    * Get whether the user can view the app store
    * @return bool
    */
    public function getViewAppStore()
    {
        return $this->viewAppStore;
    }

    /**
    * Set the list of permissions
    * @param Collection the list of permissions
    * @return $this Self object
    */
    public function setPermissions(Collection $permissions)
    {
        $this->permissions = $permissions;
        foreach ($this->permissions as $p) {
            $p->setPermissionGroup($this);
        }
        
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
    * @param AbstractPermissionInterface the permission to add
    * @return $this Self object
    */
    public function addPermission(AbstractPermissionInterface $permission)
    {
        $permission->setPermissionGroup($this);
        $this->permissions->add($permission);

        return $this;
    }

    /**
    * Remove the permission
    * @param AbstractPermissionInterface the permission to remove
    * @return $this Self object
    */
    public function removePermission(AbstractPermissionInterface $permission)
    {
        if (!$this->hasPermission($permission)) {
            throw new Exception("item not found");
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
                $permission->getResource() === $element->getResource() &&
                $permission->getCanRead() === $element->getCanRead() &&
                $permission->getCanCreate() === $element->getCanCreate() &&
                $permission->getCanUpdate() === $element->getCanUpdate() &&
                $permission->getCanDelete() === $element->getCanDelete()
            );
        });

        return $exist;
    }
}