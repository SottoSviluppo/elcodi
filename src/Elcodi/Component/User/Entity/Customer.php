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

namespace Elcodi\Component\User\Entity;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Core\Entity\Traits\ExtraDataTrait;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use Elcodi\Component\Tax\Entity\Traits\TaxableTrait;
use Elcodi\Component\User\Entity\Abstracts\AbstractUser;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Symfony\Component\Security\Core\Role\Role;

/**
 * A Customer is a User with shopping capabilities and associations,
 * such as addresses, orders, carts.
 */
class Customer extends AbstractUser implements CustomerInterface
{
    use TaxableTrait, ExtraDataTrait;

    /**
     * @var Collection
     *
     * Addresses
     */
    protected $addresses;

    /**
     * @var LanguageInterface
     *
     * Language
     */
    protected $language;

    /**
     * @var string
     *
     * Phone
     */
    protected $phone;

    /**
     * @var string
     *
     * Identity document
     */
    protected $identityDocument;

    /**
     * @var bool
     *
     * Is company
     */
    protected $company;

    /**
     * @var string
     *
     * Company name
     */
    protected $companyName;

    /**
     * @var string
     *
     * VAT
     */
    protected $vat;

    /**
     * @var string
     *
     * Fiscal code
     */
    protected $fiscalCode;

    /**
     * @var bool
     *
     * Is guest
     */
    protected $guest;

    /**
     * @var bool
     *
     * Has newsletter
     */
    protected $newsletter;

    /**
     * @var Collection
     *
     * Carts
     */
    protected $carts;

    /**
     * @var Collection
     *
     * Orders
     */
    protected $orders;

    /**
     * @var AddressInterface
     *
     * Delivery address
     */
    protected $deliveryAddress;

    /**
     * @var AddressInterface
     *
     * Invoice address
     */
    protected $invoiceAddress;

    /**
     * @var CountryInterface
     *
     * country
     */
    protected $country;

    /**
     * @var string
     *
     */
    protected $salt;

    /**
     * @var json
     *
     */
    protected $roles;

    /**
     * @var string
     *
     */
    protected $facebookId;

    /**
     * @var Collection
     *
     * Many-to-Many association between customer and categories.
     */
    protected $customerCategories;

    /**
     * User roles.
     *
     * @return string[] Roles
     */
    public function getRoles()
    {
        $realRoles = array();

        $roles = $this->roles;
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $realRoles[] = new Role($role);
            }
        }

        $realRoles[] = new Role('ROLE_CUSTOMER');

        return $realRoles;

        // return [
        //     new Role('ROLE_CUSTOMER'),
        // ];
    }

    /**
     * Set phone.
     *
     * @param string $phone Phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set identity document.
     *
     * @param string $identityDocument
     *
     * @return $this
     */
    public function setIdentityDocument($identityDocument)
    {
        $this->identityDocument = $identityDocument;

        return $this;
    }

    /**
     * Get identity document.
     *
     * @return string Identity document
     */
    public function getIdentityDocument()
    {
        return $this->identityDocument;
    }

    /**
     * Sets Guest.
     *
     * @param bool $guest Guest
     *
     * @return $this Self object
     */
    public function setGuest($guest)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Get Guest.
     *
     * @return bool Guest
     */
    public function isGuest()
    {
        return $this->guest;
    }

    /**
     * Sets company.
     *
     * @param bool $company Company
     *
     * @return $this Self object
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get Company.
     *
     * @return bool Company
     */
    public function isCompany()
    {
        return $this->company;
    }

    /**
     *
     * @param string $companyName
     *
     * @return $this
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get company name.
     *
     * @return string Identity document
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set vat.
     *
     * @param string $vat
     *
     * @return $this
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * @return string Vat
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param string $fiscalCode
     *
     * @return $this
     */
    public function setFiscalCode($fiscalCode)
    {
        $this->fiscalCode = $fiscalCode;

        return $this;
    }

    /**
     *
     * @return string Fiscal code
     */
    public function getFiscalCode()
    {
        return $this->fiscalCode;
    }

    /**
     * Sets Newsletter.
     *
     * @param bool $newsletter Newsletter
     *
     * @return $this Self object
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get Newsletter.
     *
     * @return bool Newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Add Order.
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function addOrder(OrderInterface $order)
    {
        $this->orders->add($order);

        return $this;
    }

    /**
     * Remove Order.
     *
     * @param OrderInterface $order
     *
     * @return $this Self object
     */
    public function removeOrder(OrderInterface $order)
    {
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * Set orders.
     *
     * @param Collection $orders Orders
     *
     * @return $this Self object
     */
    public function setOrders(Collection $orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get user orders.
     *
     * @return Collection Customer orders
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add Cart.
     *
     * @param CartInterface $cart
     *
     * @return $this Self object
     */
    public function addCart(CartInterface $cart)
    {
        $this->carts->add($cart);

        return $this;
    }

    /**
     * Remove Cart.
     *
     * @param CartInterface $cart
     *
     * @return $this Self object
     */
    public function removeCart(CartInterface $cart)
    {
        $this->carts->removeElement($cart);

        return $this;
    }

    /**
     * @param Collection $carts
     *
     * @return $this Self object
     */
    public function setCarts(Collection $carts)
    {
        $this->carts = $carts;

        return $this;
    }

    /**
     * Get Cart collection.
     *
     * @return Collection
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * Add address.
     *
     * @param AddressInterface $address
     *
     * @return $this Self object
     */
    public function addAddress(AddressInterface $address)
    {
        $this->addresses->add($address);

        return $this;
    }

    /**
     * Add customerCategories.
     *
     * @param CustomerCategoryInterface $customerCategories
     *
     * @return $this Self object
     */
    public function addCustomerCategories(CustomerCategory $customerCategories)
    {
        $this->customerCategories->add($customerCategories);
        return $this;
    }

    /**
     * Remove address.
     *
     * @param AddressInterface $address
     *
     * @return $this Self object
     */
    public function removeAddress(AddressInterface $address)
    {
        $this->addresses->removeElement($address);

        return $this;
    }

    /**
     * Set addresses.
     *
     * @param Collection $addresses Addresses
     *
     * @return $this Self object
     */
    public function setAddresses(Collection $addresses)
    {
        $this->addresses = $addresses;

        return $this;
    }

    public function setCustomerCategories(Collection $customerCategories)
    {
        $this->customerCategories = $customerCategories;
        return $this;
    }

    /**
     * Get addresses.
     *
     * @return Collection Addresses
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Set Delivery Address.
     *
     * @param AddressInterface $deliveryAddress
     *
     * @return $this Self object
     */
    public function setDeliveryAddress(AddressInterface $deliveryAddress = null)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get Delivery address.
     *
     * @return AddressInterface
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Set Invoice Address.
     *
     * @param AddressInterface $invoiceAddress
     *
     * @return $this Self object
     */
    public function setInvoiceAddress(AddressInterface $invoiceAddress = null)
    {
        $this->invoiceAddress = $invoiceAddress;

        return $this;
    }

    /**
     * Get Invoice address.
     *
     * @return AddressInterface
     */
    public function getInvoiceAddress()
    {
        return $this->invoiceAddress;
    }

    /**
     * Set language.
     *
     * @param LanguageInterface $language The language
     *
     * @return $this Self object
     */
    public function setLanguage(LanguageInterface $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return LanguageInterface
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set country.
     *
     * @param CountryInterface $country The country
     *
     * @return $this Self object
     */
    public function setCountry(CountryInterface $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return CountryInterface
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets Salt.
     *
     * @param string $salt
     *
     * @return $this Self object
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get Salt.
     *
     * @return string Salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets FacebookId.
     *
     * @param string $facebookId
     *
     * @return $this Self object
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get FacebookId.
     *
     * @return string FacebookId
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Get customerCategories.
     *
     * @return Collection CustomerCategories
     */
    public function getCustomerCategories()
    {
        return $this->customerCategories;
    }

    public function getString()
    {
        if ($this->isCompany()) {
            if ($this->getCompanyName() != '') {
                return $this->getCompanyName();
            }
        } else {
            if ($this->getFirstname() != '' || $this->getLastname() != '') {
                return $this->getFirstname() . ' ' . $this->getLastname();
            }
        }

        return $this->getEmail();
    }

    public function __toString()
    {
        return $this->getString();
    }
}
