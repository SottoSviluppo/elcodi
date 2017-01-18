<?php

namespace Elcodi\Component\Permissions\Repository;

use Doctrine\ORM\EntityRepository;
use Elcodi\Component\User\Entity\Interfaces\AdminUserInterface;

class PermissionGroupRepository extends EntityRepository
{
    /**
    * Find all the permissions for the specified user
    * @param AdminUserInterface the user for which search the permissions
    * @return PermissionGroup[]
    */
    public function findAllPermissionsForUser(AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');

        $result = $queryBuilder
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->setParameter('adminUserId', $adminUser->getId())
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
    * Check whether the specified user can read the specified entity
    * @param string the entity type
    * @param AdminUserInterface the current user
    * @return bool
    */
    public function canReadEntity($resource, AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');
        
        $result = $queryBuilder
            ->innerJoin('pg.permissions', 'p')
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('p.resource = :resource')
            ->andWhere('p.canRead = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->setParameter('resource', $resource)
            ->getQuery()
            ->getResult();

        return count($result) > 0;
    }

    /**
    * Check whether the specified user can create the specified entity
    * @param string the entity type
    * @param AdminUserInterface the current user
    * @return bool
    */
    public function canCreateEntity($resource, AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');
        
        $result = $queryBuilder
            ->innerJoin('pg.permissions', 'p')
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('p.resource = :resource')
            ->andWhere('p.canCreate = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->setParameter('resource', $resource)
            ->getQuery()
            ->getResult();

        return count($result) > 0;
    }

    /**
    * Check whether the specified user can update the specified entity
    * @param string the entity type
    * @param AdminUserInterface the current user
    * @return bool
    */
    public function canUpdateEntity($resource, AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');
        
        $result = $queryBuilder
            ->innerJoin('pg.permissions', 'p')
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('p.resource = :resource')
            ->andWhere('p.canCreate = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->setParameter('resource', $resource)
            ->getQuery()
            ->getResult();

        return count($result) > 0;
    }

    /**
    * Check whether the specified user can delete the specified entity
    * @param string the entity type
    * @param AdminUserInterface the current user
    * @return bool
    */
    public function canDeleteEntity($resource, AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');
        
        $result = $queryBuilder
            ->innerJoin('pg.permissions', 'p')
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('p.resource = :resource')
            ->andWhere('p.canCreate = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->setParameter('resource', $resource)
            ->getQuery()
            ->getResult();

        return count($result) > 0;
    }

    /**
    * Check whether the specified user can view the store area
    * @param AdminUserInterface the current user
    * @return bool
    */
    public function canViewStore(AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');

        $result = $queryBuilder
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('pg.viewStore = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->getQuery()
            ->getResult();

        return count($result) > 0;
    }

    /**
    * Check whether the specified user can view the shipping area
    * @param AdminUserInterface the current user
    * @return bool
    */
    public function canViewShipping(AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');

        $result = $queryBuilder
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('pg.viewShipping = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->getQuery()
            ->getResult();

        return count($result) > 0;
    }

    /**
    * Check whether the specified user can view the app store area
    * @param AdminUserInterface the current user
    * @return bool
    */
    public function canViewAppStore(AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');

        $result = $queryBuilder
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('pg.viewAppStore = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->getQuery()
            ->getResult();

        return count($result) > 0;
    }
}