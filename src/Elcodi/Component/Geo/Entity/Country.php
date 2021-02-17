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
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
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
    ExtraDataTrait,EnabledTrait;

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

    /**
     * @var bool
     *
     */
    protected $assoggetatoIVA;

     /**
     * @var string
     *
     */
    protected $dicituraFattura;

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

    /**
     * Sets assoggetatoIVA.
     *
     * @param boolean $assoggetatoIVA
     *
     * @return $this Self object
     */
    public function setAssoggetatoIVA($assoggetatoIVA)
    {
        $this->assoggetatoIVA = $assoggetatoIVA;

        return $this;
    }

    /**
     * Get assoggetatoIVA.
     *
     * @return boolean assoggetatoIVA
     */
    public function getAssoggetatoIVA()
    {
        return $this->assoggetatoIVA;
    }

    /**
     * Sets dicituraFattura.
     *
     * @param string $dicituraFattura
     *
     * @return $this Self object
     */
    public function setDicituraFattura($dicituraFattura)
    {
        $this->dicituraFattura = $dicituraFattura;

        return $this;
    }

    /**
     * Get dicituraFattura.
     *
     * @return string dicituraFattura
     */
    public function getDicituraFattura()
    {
        return $this->dicituraFattura;
    }

    public function __toString()
    {
        return $this->getName();
    }

}
