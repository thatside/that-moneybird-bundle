<?php


namespace Thatside\MoneybirdBundle\Services;

class ThatMoneybirdCodeFetcherDummyService implements CodeFetcherInterface
{
    public function getAuthorizationCode() : ?string
    {
        return null;
    }
}