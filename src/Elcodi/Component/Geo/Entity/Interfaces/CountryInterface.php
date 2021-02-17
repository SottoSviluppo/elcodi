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

namespace Elcodi\Component\Geo\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface CountryInterface.
 */
interface CountryInterface extends
IdentifiableInterface,
DateTimeInterface

{

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets IsUe.
     *
     * @param string $isUe
     *
     * @return $this Self object
     */
    public function setIsUe($isUe);

    /**
     * Get IsUe.
     *
     * @return string IsUe
     */
    public function getIsUe();

    /**
     * Sets assoggetatoIVA.
     *
     * @param boolean $assoggetatoIVA
     *
     * @return $this Self object
     */
    public function setAssoggetatoIVA($assoggetatoIVA);

    /**
     * Get assoggetatoIVA.
     *
     * @return boolean assoggetatoIVA
     */
    public function getAssoggetatoIVA();

    /**
     * Sets dicituraFattura.
     *
     * @param string $dicituraFattura
     *
     * @return $this Self object
     */
    public function setDicituraFattura($dicituraFattura);

    /**
     * Get dicituraFattura.
     *
     * @return string dicituraFattura
     */
    public function getDicituraFattura();
}
