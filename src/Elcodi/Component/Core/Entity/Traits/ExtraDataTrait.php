<?php

namespace Elcodi\Component\Core\Entity\Traits;

/**
 * Trait ExtraDataTrait.
 */
trait ExtraDataTrait
{
    /**
     * @var json
     *
     * Identifier
     */
    protected $extraData;

    /**
     * Get extraData.
     *
     * @return json extraData
     */
    public function getExtraData()
    {
        return $this->extraData;
    }

    /**
     * Sets extraData.
     *
     * @param json $extraData extraData
     *
     * @return $this Self object
     */
    public function setExtraData($extraData)
    {
        $this->extraData = $extraData;

        return $this;
    }
}
