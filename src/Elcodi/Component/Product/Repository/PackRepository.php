<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Product\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PackRepository.
 */
class PackRepository extends EntityRepository
{

    public function getPacksWithPurchasableId($purchasableId)
    {
        $query = $this->createQueryBuilder('c')
            ->select('c')
            ->innerJoin('c.purchasables', 'purchasables')
            ->andWhere('purchasables.id = :id')
            ->setParameter('id', $purchasableId)
        // ->groupBy('c.id')
        ;
        return $query->getQuery()->getResult();
    }
}
