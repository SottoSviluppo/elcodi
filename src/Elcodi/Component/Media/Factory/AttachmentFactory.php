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
 * @author Aldo Chiecchia <zattachment@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Media\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Media\Entity\Interfaces\AttachmentInterface;

/**
 * Class AttachmentFactory.
 */
class AttachmentFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * Queries should be implemented in a repository class
     *
     * This method must always returns an empty instance of the related Entity
     * and initializes it in a consistent state
     *
     * @return AttachmentInterface Empty entity
     */
    public function create()
    {
        /**
         * @var AttachmentInterface $attachment
         */
        $classNamespace = $this->getEntityNamespace();
        $attachment = new $classNamespace();
        $attachment
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $attachment;
    }
}
