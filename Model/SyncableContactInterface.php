<?php


namespace Thatside\MoneybirdBundle\Model;

use Thatside\MoneybirdBundle\DTO\MoneybirdContactData;

/**
 * Interface SyncableContactInterface
 * All entities which should be synced with Moneybird should implement this interface
 */
interface SyncableContactInterface
{
    /**
     * Transform current entity into DTO to create a corresponding contact on Moneybird side
     *
     * @return MoneybirdContactData
     */
    public function getMoneybirdContactData();
}