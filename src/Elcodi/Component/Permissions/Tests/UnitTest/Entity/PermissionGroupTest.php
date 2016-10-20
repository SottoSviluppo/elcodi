<?php

namespace Elcodi\Component\Permissions\Tests\UnitTest\Entity;

use Elcodi\Component\Permissions\Entity\PermissionGroup;
use Elcodi\Component\Core\Tests\UnitTest\Entity\AbstractEntityTest;
use Doctrine\Common\Collections\ArrayCollection;

use Exception;

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

    public function testAddPermissionShouldThrowExceptionIfAlreadyInCollection()
    {
        $pg = new PermissionGroup();
        $pg->setName('my-group');

        $permissionNumber = $pg->getPermissions()->count();
        $pg->addPermission('my-resource', true, true, true, true);
        $pg->addPermission('my-resource', true, true, true, true);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Permission already in collection');
    }

    public function testRemovePermissionShouldDecrementPermissions()
    {
        $pg = new PermissionGroup();
        $pg->setName('my-group');

        $p = new Permission;
        $p->setid(1)
            ->setResource('my-resource')
            ->setCanRead(true)
            ->setCanCreate(true)
            ->setCanUpdate(true)
            ->setCanDelete(true);

        $pg->setPermissions(new ArrayCollection([$p]));
        $permissionNumber = $pg->getPermissions()->count();

        $pg->removePermission($p);

        $this->assertEquals($permissionNumber-1, $pg->getPermissions()->count());
    }

    public function testRemovePermissionShouldThrowExceptionIfNotInCollection()
    {
        $pg = new PermissionGroup();
        $pg->setName('my-group');

        $p = new Permission;
        $p->setid(1)
            ->setResource('my-resource')
            ->setCanRead(true)
            ->setCanCreate(true)
            ->setCanUpdate(true)
            ->setCanDelete(true);

        $pg->removePermission($p);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('item not found');
    }
}
