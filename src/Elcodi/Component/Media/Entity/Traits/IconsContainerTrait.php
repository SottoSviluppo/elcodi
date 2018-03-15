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

namespace Elcodi\Component\Media\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait IconsContainerTrait.
 */
trait IconsContainerTrait
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * Icons
     */
    protected $icons;

    /**
     * @var string
     *
     * Images sort
     */
    protected $iconsSort;

    /**
     * Set add image.
     *
     * @param \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $icon Image object to be added
     *
     * @return $this Self object
     */
    public function addIcon(\Elcodi\Component\Media\Entity\Interfaces\ImageInterface $icon)
    {
        if ($this->icons == null) {
            $this->icons = new \Doctrine\Common\Collections\ArrayCollection();
        }

        $this->icons->add($icon);

        return $this;
    }

    /**
     * Get if entity is enabled.
     *
     * @param \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $icon Image object to be removed
     *
     * @return $this Self object
     */
    public function removeIcon(\Elcodi\Component\Media\Entity\Interfaces\ImageInterface $icon)
    {
        $this->icons->removeElement($icon);

        return $this;
    }

    /**
     * Get all icons.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * Get first icon if is defined.
     *
     * @return \Elcodi\Component\Media\Entity\Interfaces\ImageInterface
     */
    public function getIcon()
    {
        $icons = $this->getIcons();
        if (empty($icons)) {
            return null;
        }
        return $icons[0];
    }

    /**
     * Get sorted icons.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSortedIcons()
    {
        $iconsSort = explode(',', $this->getIconsSort());
        $orderCollection = array_reverse($iconsSort);
        $iconsCollection = $this
            ->getImages()
            ->toArray();

        usort(
            $iconsCollection,
            function (
                \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $a,
                \Elcodi\Component\Media\Entity\Interfaces\ImageInterface $b
            ) use ($orderCollection) {

                $aPos = array_search($a->getId(), $orderCollection);
                $bPos = array_search($b->getId(), $orderCollection);

                return ($aPos < $bPos)
                ? 1
                : -1;
            }
        );

        return new ArrayCollection($iconsCollection);
    }

    /**
     * Set icons.
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $icons Images
     *
     * @return $this Self object
     */
    public function setIcons(\Doctrine\Common\Collections\ArrayCollection $icons)
    {
        $this->icons = $icons;

        return $this;
    }

    /**
     * Get IconsSort.
     *
     * @return string IconsSort
     */
    public function getIconsSort()
    {
        return $this->iconsSort;
    }

    /**
     * Sets IconsSort.
     *
     * @param string $iconsSort IconsSort
     *
     * @return $this Self object
     */
    public function setIconsSort($iconsSort)
    {
        $this->iconsSort = $iconsSort;

        return $this;
    }

}
