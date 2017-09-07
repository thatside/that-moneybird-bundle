<?php


namespace Thatside\MoneybirdBundle\Services;

class ThatMoneybirdCodeFetcherDummyService implements CodeFetcherInterface
{
    public function getAuthorizationCode()
    {
        return null;
    }
    
    public function getAuthorizationToken()
    {
        return null;
    }
}