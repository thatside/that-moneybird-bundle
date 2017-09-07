<?php


namespace Thatside\MoneybirdBundle\Services;

use Picqer\Financials\Moneybird\Connection;
use Picqer\Financials\Moneybird\Moneybird;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thatside\MoneybirdBundle\Event\MoneybirdTokenEvent;

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
    
    public function __construct(Connection $connection, CodeFetcherInterface $codeFetcher, EventDispatcherInterface $dispatcher)
    {
        $this->connection = $connection;
        $this->codeFetcher = $codeFetcher;
        $this->eventDispatcher = $dispatcher;
        
        $this->initMoneybird();
    }

    public function initMoneybird()
    {
        if ($this->isMoneybirdEnabled()) {
            $this->updateAuthCode();            
            $this->connection->setAuthorizationCode($this->authCode);

            $this->updateToken();
            dump($this->connection->getAccessToken());
            $this->connection->setAccessToken($this->token);
            dump($this->token);
            dump($this->connection->getAccessToken());
            
            try {
                $this->connection->connect();
            } catch (\Exception $e) {
                throw new \Exception('Could not connect to Moneybird: ' . $e->getMessage());
            }
            
            $token = $this->connection->getAccessToken();
            $this->eventDispatcher->dispatch(MoneybirdTokenEvent::NAME,new MoneybirdTokenEvent($token));
            
            $this->moneybird = new Moneybird($this->connection);
        }
    }
    
    private function updateAuthCode() {
        $this->authCode = $this->codeFetcher->getAuthorizationCode();
    }
    
    private function updateToken() {
        $this->token = $this->codeFetcher->getAuthorizationToken();
    }

    public function getMoneybird()
    {
        return $this->moneybird;
    }

    /**
     * Check if moneybird is enabled for client (if auth code is not null)
     * @return bool
     */
    public function isMoneybirdEnabled()
    {
        return $this->codeFetcher->getAuthorizationCode() !== null;
    }

    public function setAdministrationId($id)
    {
        $this->connection->setAdministrationId($id);
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