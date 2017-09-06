<?php


namespace Thatside\MoneybirdBundle\Services;

interface CodeFetcherInterface
{
    /**
     * Get authorization code from your application storage
     * @return string
     */
    public function getAuthorizationCode() : ?string;
}