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
}