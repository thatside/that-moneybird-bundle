<?php

namespace Thatside\MoneybirdBundle\DTO;

use Assert\Assert;
use Picqer\Financials\Moneybird\Entities\SalesInvoiceDetail;

class MoneybirdInvoiceDetailsData extends SalesInvoiceDetail
{
    public function __construct()
    {

    }

    /**
     * Validate DTO
     */
    public function validate()
    {
        Assert::that($this->description, 'Description is invalid')->notNull();

        Assert::that($this->price, 'Price is invalid')->notNull();

        Assert::that($this->amount,'Amount is invalid')->notNull();
    }
}