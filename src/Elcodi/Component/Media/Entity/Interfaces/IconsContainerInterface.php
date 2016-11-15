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

namespace Elcodi\Component\Media\Entity\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface IconsContainerInterface.
 */
interface IconsContainerInterface
{
    /**
     * Set add image.
     *
     * @param ImageInterface $icon Image object to be added
     *
     * @return $this Self object
     */
    public function addIcon(ImageInterface $icon);

    /**
     * Get if entity is enabled.
     *
     * @param ImageInterface $icon Image object to be removed
     *
     * @return $this Self object
     */
    public function removeIcon(ImageInterface $icon);

    /**
     * Get all images.
     *
     * @return ArrayCollection
     */
    public function getIcons();

    /**
     * Set images.
     *
     * @param ArrayCollection $icons Icons
     *
     * @return $this Self object
     */
    public function setIcons(ArrayCollection $icons);

    /**
     * Get sorted images.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSortedIcons();

    /**
     * Get IconsSort.
     *
     * @return string IconsSort
     */
    public function getIconsSort();

    /**
     * Sets IconsSort.
     *
     * @param string $iconsSort IconsSort
     *
     * @return $this Self object
     */
    public function setIconsSort($iconsSort);
}
