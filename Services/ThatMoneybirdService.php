<?php


namespace Thatside\MoneybirdBundle\Services;

use DTO\MoneybirdWebhookData;
use Picqer\Financials\Moneybird\Connection;
use Picqer\Financials\Moneybird\Entities\Administration;
use Picqer\Financials\Moneybird\Entities\Contact;
use Picqer\Financials\Moneybird\Entities\SalesInvoice;
use Picqer\Financials\Moneybird\Entities\Webhook;
use Picqer\Financials\Moneybird\Moneybird;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thatside\MoneybirdBundle\Event\MoneybirdTokenEvent;
use Thatside\MoneybirdBundle\Model\SyncableContactInterface;
use Thatside\MoneybirdBundle\Model\SyncableInvoiceInterface;

/**
 * Class ThatMoneybirdService
 * Provides wrapper for Moneybird PHP client by picqer
 */
class ThatMoneybirdService
{
    /** @var Connection  */
    protected $connection;
    /** @var  Moneybird */
    protected $moneybird = null;
    /** @var  CodeFetcherInterface */
    protected $codeFetcher;
    /** @var  EventDispatcherInterface */
    protected $eventDispatcher;
    /** @var  string|null */
    protected $authCode;
    /** @var  string */
    protected $token;

    /**
     * ThatMoneybirdService constructor.
     *
     * @param Connection $connection
     * @param CodeFetcherInterface $codeFetcher
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(Connection $connection, CodeFetcherInterface $codeFetcher, EventDispatcherInterface $dispatcher)
    {
        $this->connection = $connection;
        $this->codeFetcher = $codeFetcher;
        $this->eventDispatcher = $dispatcher;

        $this->initMoneybird();
    }

    /**
     * Initialize Moneybird connection and main class, set up token and refresh it if needed
     *
     * @throws \Exception
     */
    public function initMoneybird()
    {
        if ($this->isMoneybirdEnabled()) {
            $this->updateAuthCode();
            $this->connection->setAuthorizationCode($this->authCode);

            $this->updateToken();
            $this->connection->setAccessToken($this->token);

            try {
                $this->connection->connect();
            } catch (\Exception $e) {
                throw new \Exception('Could not connect to Moneybird: ' . $e->getMessage());
            }

            $token = $this->connection->getAccessToken();
            $this->eventDispatcher->dispatch(MoneybirdTokenEvent::NAME, new MoneybirdTokenEvent($token));

            $this->connection->setAdministrationId($this->codeFetcher->getAdministrationId());

            $this->moneybird = new Moneybird($this->connection);
        }
    }

    /**
     * @return Moneybird
     */
    public function getMoneybird()
    {
        return $this->moneybird;
    }

    /**
     * Get Moneybird authorization URL from private method of Connection class
     *
     * @return string
     */
    public function getAuthUrl()
    {
        $connectionReflection = new \ReflectionClass($this->connection);
        $getAuthUrlMethod = $connectionReflection->getMethod('getAuthUrl');
        $getAuthUrlMethod->setAccessible(true);
        $authUrl = $getAuthUrlMethod->invoke($this->connection);

        return $authUrl;
    }

    /**
     * Check if moneybird is enabled for client (if auth code is not null)
     * @return bool
     */
    public function isMoneybirdEnabled()
    {
        return $this->codeFetcher->getAuthorizationCode() !== null;
    }

    /**
     * @param string $id
     */
    public function setAdministrationId($id)
    {
        $this->connection->setAdministrationId($id);
    }

    /**
     * @return Administration[]
     */
    public function getAdministrations()
    {
        $administrationId = $this->codeFetcher->getAdministrationId();
        $this->connection->setAdministrationId(null);
        $administrations = $this->moneybird->administration()->getAll();
        $this->connection->setAdministrationId($administrationId);

        return $administrations;
    }

    /**
     * Create Moneybird contact
     * @param SyncableContactInterface $contact
     *
     * @return Contact
     */
    public function syncContact(SyncableContactInterface $contact)
    {
        if ($this->isMoneybirdEnabled()) {
            $contactData = $contact->getMoneybirdContactData();
            $contactData->validate();

            return $this->moneybird->contact($contactData->attributes())->save();
        } else {
            throw new \BadMethodCallException('Moneybird is not enabled at the moment.');
        }
    }

    public function clearInvoiceDetails(SyncableInvoiceInterface $syncableInvoice)
    {
        if ($this->isMoneybirdEnabled()) {
            $invoiceId = $syncableInvoice->getMoneybirdInvoiceId();
            if ($invoiceId) {
                $invoice = $this->moneybird->salesInvoice()->find($syncableInvoice->getMoneybirdInvoiceId());

                $details = $invoice->details;
                foreach ($details as $detail) {
                    $detail->_destroy = true;
                }

                $invoice->details = $details;
                $invoice->save();
            }
        } else {
            throw new \BadMethodCallException('Moneybird is not enabled at the moment.');
        }
    }

    public function syncInvoice(SyncableInvoiceInterface $syncableInvoice)
    {
        if ($this->isMoneybirdEnabled()) {
            $invoiceData = $syncableInvoice->getMoneybirdInvoiceData();
            $invoiceData->validate();

            return $this->moneybird->salesInvoice($invoiceData->attributes())->save();
        } else {
            throw new \BadMethodCallException('Moneybird is not enabled at the moment.');
        }
    }

    public function createWebhook(MoneybirdWebhookData $webhookData)
    {
        if ($this->isMoneybirdEnabled()) {
            $webhookData->validate();

            return $this->moneybird->webhook($webhookData->attributes())->save();
        } else {
            throw new \BadMethodCallException('Moneybird is not enabled at the moment.');
        }
    }

    public function removeWebhook(MoneybirdWebhookData $webhookData)
    {
        if ($this->isMoneybirdEnabled()) {
            $webhookData->validate();

            return $this->moneybird->webhook($webhookData->attributes())->delete();
        } else {
            throw new \BadMethodCallException('Moneybird is not enabled at the moment.');
        }
    }

    /**
     * Update authorization code from code fetcher
     */
    private function updateAuthCode()
    {
        $this->authCode = $this->codeFetcher->getAuthorizationCode();
    }

    /**
     * Update auth token from code fetcher
     */
    private function updateToken()
    {
        $this->token = $this->codeFetcher->getAccessToken();
    }
}