<?php


namespace Thatside\MoneybirdBundle\Services;

use Picqer\Financials\Moneybird\Connection;
use Picqer\Financials\Moneybird\Moneybird;

class ThatMoneybirdService
{
    /** @var Connection  */
    protected $connection;
    /** @var  Moneybird */
    protected $moneybird = null;
    /** @var  CodeFetcherInterface */
    protected $codeFetcher;
    /** @var  string|null */
    protected $authCode;
    /** @var  string */
    protected $token;
    
    public function __construct(Connection $connection, CodeFetcherInterface $codeFetcher)
    {
        $this->connection = $connection;
        $this->codeFetcher = $codeFetcher;
        
        $this->initMoneybird();
    }

    public function initMoneybird()
    {
        if ($this->authCode === null) {
            $this->updateAuthCode();
        }
        if ($this->authCode !== null) {
            $this->connection->setAuthorizationCode($this->authCode);
            $this->moneybird = new Moneybird($this->connection);
        }
    }
    
    private function updateAuthCode() {
        $this->authCode = $this->codeFetcher->getAuthorizationCode();
    }

    public function getMoneybird() : Moneybird
    {
        return $this->moneybird;
    }

    public function authenticate()
    {
        $this->connection->redirectForAuthorization();
    }

    public function getAdministrations()
    {
        return $this->moneybird->administration()->getAll();
    }
}