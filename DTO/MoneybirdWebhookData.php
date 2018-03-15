<?php

namespace DTO;

use Assert\Assert;
use Picqer\Financials\Moneybird\Entities\Webhook;

class MoneybirdWebhookData extends Webhook
{

    public function __construct()
    {

    }

    /**
     * Validate DTO
     */
    public function validate()
    {
        Assert::that($this->url, 'Webhook url invalid')->notNull();

        Assert::that($this->events, 'Webhook events')->nullOr()->isArray();
    }

}