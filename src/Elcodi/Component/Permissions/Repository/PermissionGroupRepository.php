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
    public function canReadEntity($entityType, AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');
        
        $result = $queryBuilder
            ->select('p')
            ->innerJoin('pg.permissions', 'p')
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('p.entityType = :entityType')
            ->andWhere('p.canRead = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->setParameter('entityType', $entityType)
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
    public function canCreateEntity($entityType, AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');
        
        $result = $queryBuilder
            ->select('p')
            ->innerJoin('pg.permissions', 'p')
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('p.entityType = :entityType')
            ->andWhere('p.canCreate = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->setParameter('entityType', $entityType)
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
    public function canUpdateEntity($entityType, AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');
        
        $result = $queryBuilder
            ->select('p')
            ->innerJoin('pg.permissions', 'p')
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('p.entityType = :entityType')
            ->andWhere('p.canUpdate = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->setParameter('entityType', $entityType)
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
    public function canDeleteEntity($entityType, AdminUserInterface $adminUser)
    {
        $queryBuilder = $this->createQueryBuilder('pg');
        
        $result = $queryBuilder
            ->select('p')
            ->innerJoin('pg.permissions', 'p')
            ->innerJoin('pg.adminUser', 'a')
            ->where('a.id = :adminUserId')
            ->andWhere('p.entityType = :entityType')
            ->andWhere('p.canDelete = true')
            ->setParameter('adminUserId', $adminUser->getId())
            ->setParameter('entityType', $entityType)
            ->getQuery()
            ->getResult();

        return count($result) > 0;
    }
}