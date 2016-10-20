<?php

namespace Elcodi\Component\Permissions\Entity\Abstracts;

use Elcodi\Component\Permissions\Entity\Interfaces\IAbstractPermission;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;

abstract class AbstractPermission implements IAbstractPermission
{
    use IdentifiableTrait;
    
    /**
    * @var string
    * The entity type
    */
    protected $resource;

    /**
    * @var bool
    * Whether the user can read the entity
    */
    protected $canRead;

    /**
    * @var bool
    * Whether the user can create the entity
    */
    protected $canCreate;

    /**
    * @var bool
    * Whether the user can update the entity
    */
    protected $canUpdate;

    /**
    * @var bool
    * Whether the user can delete the entity
    */
    protected $canDelete;

    /**
    * Get the resource for the permission
    * @return string
    */
    public function getResource()
    {
        return $this->entityType;
    }

    /**
    * Set the resource
    * @param string the resource name
    * @return $this Self object
    */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
    * Get the read permission
    * @return bool
    */
    public function getCanRead()
    {
        return $this->canRead;
    }

    /**
    * Set the read permission
    * @param bool the read permission value
    * @return $this Self object
    */
    public function setCanRead($canRead)
    {
        $this->canRead = $canRead;
        return $this;
    }

    /**
    * Get the create permission
    * @return bool
    */
    public function getCanCreate()
    {
        return $this->canCreate;
    }

    /**
    * Set the create permission
    * @param bool the create permission value
    * @return $this Self object
    */
    public function setCanCreate($canCreate)
    {
        $this->canCreate = $canCreate;
        return $this;
    }

    /**
    * Get the update permission
    * @return bool
    */
    public function getCanUpdate()
    {
        return $this->canUpdate;
    }

    /**
    * Set the update permission
    * @param bool the update permission value
    * @return $this Self object
    */
    public function setCanUpdate($canUpdate)
    {
        $this->canUpdate = $canUpdate;
        return $this;
    }

    /**
    * Get the delete permission
    * @return bool
    */
    public function getCanDelete()
    {
        return $this->canDelete;
    }

    /**
    * Set the delete permission
    * @param bool the delete permission value
    * @return $this Self object
    */
    public function setCanDelete($canDelete)
    {
        $this->canDelete = $canDelete;
        return $this;
    }
}