<?php


namespace Thatside\MoneybirdBundle\Model;


use Thatside\MoneybirdBundle\DTO\MoneybirdInvoiceData;

/**
 * Interface SyncableInvoiceInterface
 */
interface SyncableInvoiceInterface
{
    /**
     * Transform current entity into DTO to create a corresponding invoice on Moneybird side
     *
     * @return MoneybirdInvoiceData
     */
    public function getMoneybirdInvoiceData();
}