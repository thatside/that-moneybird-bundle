<?php


namespace Thatside\MoneybirdBundle\DTO;

use Assert\Assert;
use Picqer\Financials\Moneybird\Entities\Contact;

/**
 * Class MoneybirdContactData
 *
 */
class MoneybirdContactData extends Contact
{
    public function __construct()
    {

    }

    /**
     * Validate DTO
     */
    public function validate()
    {
        if ($this->company_name === null) {
            Assert::lazy()
                ->that($this->first_name, 'firstName', 'First name should be provided')->notEmpty()
                ->that($this->last_name, 'lastName', 'Last name should be provided')->notEmpty()
                ->verifyNow();
        } else {
            Assert::lazy()
                ->that($this->company_name, 'companyName', 'Company name should be provided')->notEmpty()
                ->verifyNow();
        }

        if ($this->country !== null) {
            Assert::that($this->country, 'Country code invalid')->length(2);
        }
        if ($this->email !== null) {
            Assert::that($this->email, 'Email invalid')->notNull()->email();
        }
        if ($this->delivery_method !== null) {
            Assert::that($this->delivery_method, 'Delivery method invalid')->notNull();
        }

        if ($this->send_invoices_to_email !== null) {
            Assert::that($this->send_invoices_to_email, 'Invoices email invalid')->notNull();
        }
        if ($this->send_estimates_to_email !== null) {
            Assert::that($this->send_estimates_to_email, 'Estimates email invalid')->notNull();
        }

        if ($this->sepa_active === true) {
            Assert::lazy()
                ->that($this->sepa_iban, 'sepa_iban', 'IBAN invalid')->notNull()
                ->that($this->sepa_iban_account_name, 'sepa_iban_account_name', 'IBAN account name invalid')->notNull()
                ->that($this->sepa_bic, 'sepa_bic', 'BIC invalid')->notNull()
                ->that($this->sepa_mandate_id, 'sepa_mandate_id', 'Mandate ID invalid')->notNull()
                ->that($this->sepa_mandate_date, 'sepa_mandate_date', 'Mandate date invalid')->notNull()->isInstanceOf(\DateTime::class)
                ->that($this->sepa_sequence_type, 'sepa_sequence_type', 'Sequence type invalid')->notNull()->choice(array('RCUR', 'FRST', 'OOFF', 'FNAL'))
                ->verifyNow();
        }
    }
}