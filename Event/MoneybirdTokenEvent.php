<?php


namespace Thatside\MoneybirdBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class MoneybirdTokenEvent extends Event
{
    const NAME = 'moneybird.token_update';
    
    /** @var string  */
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }
}