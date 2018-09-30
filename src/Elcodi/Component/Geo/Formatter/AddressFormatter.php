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

namespace Elcodi\Component\Geo\Formatter;

use Elcodi\Component\Geo\Adapter\LocationProvider\Interfaces\LocationProviderAdapterInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;

/**
 * Class AddressFormatter.
 */
class AddressFormatter
{
    /**
     * @var LocationProviderAdapterInterface
     *
     * The location provider interface
     */
    private $locationProvider;

    /**
     * Builds a new address formatter.
     *
     * @param LocationProviderAdapterInterface $locationProvider A location provider
     */
    public function __construct(LocationProviderAdapterInterface $locationProvider)
    {
        $this->locationProvider = $locationProvider;
    }

    /**
     * Formats an address on an array.
     *
     * @param AddressInterface $address The address to format
     *
     * @return array
     */
    public function toArray(AddressInterface $address)
    {
        $cityLocationId = $address->getCity();

        $addressArray = [
            'id' => $address->getId(),
            'name' => $address->getName(),
            'recipientName' => $address->getRecipientName(),
            'recipientSurname' => $address->getRecipientSurname(),
            'address' => $address->getAddress(),
            'addressMore' => $address->getAddressMore(),
            'city' => $address->getCity(),
            'country' => $this->getCountryName($address),
            'postalCode' => $address->getPostalcode(),
            'phone' => $address->getPhone(),
            'province' => '',
            'mobile' => $address->getMobile(),
            'comment' => $address->getComments(),
        ];

        if (method_exists($address, 'getProvince')) {
            $addressArray['province'] = $address->getProvince();
        }

        $addressArray['fullAddress'] =
        $this->buildFullAddressString(
            $address
        );
        $addressArray['realFullAddress'] =
        $this->buildRealFullAddressString(
            $address
        );

        return $addressArray;
    }

    /**
     * Builds a full address string.
     *
     * @param AddressInterface $address       The address
     * @param array            $cityHierarchy The full city hierarchy
     *
     * @return string
     */
    protected function buildFullAddressString(
        AddressInterface $address
    ) {
        // $cityString = implode(', ', $cityHierarchy);

        return sprintf(
            '%s %s %s, %s, %s',
            $address->getAddress(),
            $address->getAddressMore(),
            $address->getCity(),
            $address->getPostalcode(),
            $this->getCountryName($address)
        );
    }

    protected function buildRealFullAddressString(
        AddressInterface $address
    ) {
        $string = sprintf(
            "%s %s\r\n%s %s, %s %s\r\n%s\r\n",
            $address->getRecipientName(),
            $address->getRecipientSurname(),
            $address->getAddress(),
            $address->getAddressMore(),
            $address->getCity(),
            $address->getPostalcode(),
            $this->getCountryName($address)
        );

        // if ($address->getPhone() != '') {
        //     $string .= "\r\nTel. " . $address->getPhone();
        // }

        // if ($address->getMobile() != '') {
        //     $string .= "\r\nCell. " . $address->getMobile();
        // }

        // if ($address->getComments() != '') {
        //     $string .= "\r\nNote. " . $address->getComments();
        // }

        return $string;
    }

    protected function getCountryName($address)
    {
        $country = $address->getCountry();
        $countryName = "";
        if ($country !== null) {
            $countryName = $country->getName();
        }

        return $countryName;
    }
}
