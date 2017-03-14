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

namespace Elcodi\Component\Geo\Entity;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\ExtraDataTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;

/**
 * Class Country.
 */
class Country implements CountryInterface
{
    use IdentifiableTrait,
    DateTimeTrait,
        ExtraDataTrait
    ;

    /**
     * @var string
     *
     */
    protected $name;

    /**
     * @var bool
     *
     */
    protected $isUe;

    public function __construct()
    {
    }

    /**
     * Sets Name.
     *
     * @param string $name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets IsUe.
     *
     * @param string $isUe
     *
     * @return $this Self object
     */
    public function setIsUe($isUe)
    {
        $this->isUe = $isUe;

        return $this;
    }

    /**
     * Get IsUe.
     *
     * @return string IsUe
     */
    public function getIsUe()
    {
        return $this->isUe;
    }

    public function __toString()
    {
        return $this->getName();
    }

}
