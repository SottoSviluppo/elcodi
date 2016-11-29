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

namespace Elcodi\Component\Product\Entity;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\ETaggableTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Media\Entity\Traits\ImagesContainerTrait;
use Elcodi\Component\Media\Entity\Traits\PrincipalImageTrait;
use Elcodi\Component\MetaData\Entity\Traits\MetaDataTrait;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;
use Elcodi\Component\Product\Entity\Traits\PurchasablePriceTrait;
use Elcodi\Component\Tax\Entity\Traits\TaxableTrait;

/**
 * Class Purchasable.
 */
abstract class Purchasable implements PurchasableInterface
{
    use IdentifiableTrait,
    DateTimeTrait,
    ETaggableTrait,
    MetaDataTrait,
    ImagesContainerTrait,
    PrincipalImageTrait,
    EnabledTrait,
    DimensionsTrait,
    TaxableTrait,
        PurchasablePriceTrait;

    /**
     * @var string
     *
     * Slug
     */
    protected $slug;

    /**
     * @var string
     *
     * Product SKU
     */
    protected $sku;

    /**
     * @var int
     *
     * Stock
     */
    protected $stock;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Short description
     */
    protected $shortDescription;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var string
     *
     * Barcode
     */
    protected $barcode;

    /**
     * @var bool
     *
     * Product must show in home
     */
    protected $showInHome;

    /**
     * @var bool
     *
     * Keeps cart price without replacing it every time
     */
    protected $keepCartPrice;

    /**
     * @var bool
     *
     * Adds a cartline every different purchase
     */
    protected $userCustomizable;

    /**
     * @var string
     *
     * Product dimensions
     */
    protected $dimensions;

    /**
     * @var ManufacturerInterface
     *
     * Manufacturer
     */
    protected $manufacturer;

    /**
     * @var Collection
     *
     * Many-to-Many association between products and categories.
     */
    protected $categories;

    /**
     * @var CategoryInterface
     *
     * Principal category
     */
    protected $principalCategory;

    /**
     * @var string
     *
     * Purchasable type
     */
    protected $purchasableType;

    /**
     * Get Slug.
     *
     * @return string Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets Slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get Sku.
     *
     * @return string Sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Sets Sku.
     *
     * @param string $sku Sku
     *
     * @return $this Self object
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get Stock.
     *
     * @return int Stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Sets Stock.
     *
     * @param int $stock Stock
     *
     * @return $this Self object
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

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
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get ShortDescription.
     *
     * @return string ShortDescription
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Sets ShortDescription.
     *
     * @param string $shortDescription ShortDescription
     *
     * @return $this Self object
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get Description.
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets Description.
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Barcode.
     *
     * @return string Barcode
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Sets Barcode.
     *
     * @param string $barcode Barcode
     *
     * @return $this Self object
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get ShowInHome.
     *
     * @return bool ShowInHome
     */
    public function getShowInHome()
    {
        return $this->showInHome;
    }

    /**
     * Sets ShowInHome.
     *
     * @param bool $showInHome ShowInHome
     *
     * @return $this Self object
     */
    public function setShowInHome($showInHome)
    {
        $this->showInHome = $showInHome;

        return $this;
    }

    /**
     * Get KeepCartPrice.
     *
     * @return bool KeepCartPrice
     */
    public function getKeepCartPrice()
    {
        return $this->keepCartPrice;
    }

    /**
     * Sets KeepCartPrice.
     *
     * @param bool $keepCartPrice KeepCartPrice
     *
     * @return $this Self object
     */
    public function setKeepCartPrice($keepCartPrice)
    {
        $this->keepCartPrice = $keepCartPrice;

        return $this;
    }

    /**
     * Get UserCustomizable.
     *
     * @return bool UserCustomizable
     */
    public function getUserCustomizable()
    {
        return $this->userCustomizable;
    }

    /**
     * Sets UserCustomizable.
     *
     * @param bool $userCustomizable UserCustomizable
     *
     * @return $this Self object
     */
    public function setUserCustomizable($userCustomizable)
    {
        $this->userCustomizable = $userCustomizable;

        return $this;
    }

    /**
     * Get Dimensions.
     *
     * @return string Dimensions
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Sets Dimensions.
     *
     * @param string $dimensions Dimensions
     *
     * @return $this Self object
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Product manufacturer.
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory()
    {
        return $this->principalCategory;
    }

    /**
     * Get purchasable type.
     *
     * @return string Purchasable type
     */
    public function getPurchasableType()
    {
        return 'purchasable';
    }
}
