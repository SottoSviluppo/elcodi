<?php

namespace Elcodi\Component\Permissions\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
* Represents a permission API
*/
interface AbstractPermissionInterface extends IdentifiableInterface
{
    /**
    * Get the entity type for the permission
    * @return string
    */
    function getEntityType();

    /**
    * Set the entity type
    * @param string the entity type name
    * @return $this Self object
    */
    function setEntityType($entityType);

    /**
    * Get the read permission
    * @return bool
    */
    function getCanRead();

    /**
    * Set the read permission
    * @param bool the read permission value
    * @return $this Self object
    */
    function setCanRead($canRead);

    /**
    * Get the create permission
    * @return bool
    */
    function getCanCreate();

    /**
    * Set the create permission
    * @param bool the create permission value
    * @return $this Self object
    */
    function setCanCreate($canCreate);

    /**
    * Get the update permission
    * @return bool
    */
    function getCanUpdate();

    /**
    * Set the update permission
    * @param bool the update permission value
    * @return $this Self object
    */
    function setCanUpdate($canUpdate);

    /**
    * Get the delete permission
    * @return bool
    */
    function getCanDelete();

    /**
    * Set the delete permission
    * @param bool the delete permission value
    * @return $this Self object
    */
    function setCanDelete($canDelete);
}
