<?php


namespace Thatside\MoneybirdBundle\Model;


use Thatside\MoneybirdBundle\DTO\MoneybirdInvoiceDetailsData;

interface SyncableInvoiceLineInterface
{
    /**
     * Transform current entity into DTO to create a corresponding invoice details line on Moneybird side
     *
     * @return MoneybirdInvoiceDetailsData;
     */
    public function getMoneybirdInvoiceDetailsData();
}