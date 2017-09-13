<?php


namespace Thatside\MoneybirdBundle\Services;

class ThatMoneybirdCodeFetcherDummyService implements CodeFetcherInterface
{
    const AUTH_CODE = 'AUTHORIZATION_CODE';
    const AUTH_TOKEN = 'AUTHORIZATION_TOKEN';
    
    public function getAuthorizationCode()
    {
        return self::AUTH_CODE;
    }
    
    public function getAuthorizationToken()
    {
        return self::AUTH_TOKEN;
    }
}