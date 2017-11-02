<?php

namespace Thatside\MoneybirdBundle\DTO;

use Assert\Assert;
use Picqer\Financials\Moneybird\Entities\SalesInvoice;

class MoneybirdInvoiceData extends SalesInvoice
{
    public function __construct()
    {

    }

    /**
     * Validate DTO
     */
    public function validate()
    {
        Assert::that($this->contact_id, 'Contact id invalid')->notNull();

        Assert::that($this->invoice_date, 'Invoice date invalid')->notNull();

        Assert::that($this->currency, 'Currency invalid')->notNull()->length(3);

        Assert::that($this->details, 'Details invalid')->isArray();
    }
}