<?php

namespace Elcodi\Component\Permissions\Tests\UnitTest\Entity;

use Elcodi\Component\Permissions\Entity\PermissionGroup;
use Elcodi\Component\Core\Tests\UnitTest\Entity\AbstractEntityTest;

class PermissionGroupTest extends AbstractEntityTest
{
    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    public function getEntityNamespace()
    {
        return 'Elcodi\Component\Permissions\Entity\PermissionGroup';
    }

    public function getTestableFields()
    {
        return [
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getAdminUser',
                'setter' => 'setAdminUser',
                'value' => 'Elcodi\Component\User\Entity\Interfaces\AdminUserInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getName',
                'setter' => 'setName',
                'value' => 'my-group',
                'nullable' => false,
            ]]
        ];
    }

    public function testAddPermissionShouldIncrementPermissions()
    {
        $pg = new PermissionGroup();
        $pg->setName('my-group');

        $permissionNumber = $pg->getPermissions()->count();
        $pg->addPermission('my-resource', true, true, true, true);

        $this->assertEquals($permissionNumber+1, $pg->getPermissions()->count());
    }
}
