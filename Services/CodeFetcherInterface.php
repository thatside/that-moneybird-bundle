<?php


namespace Thatside\MoneybirdBundle\Services;

/**
 * Interface CodeFetcherInterface
 */
interface CodeFetcherInterface
{
    /**
     * Get authorization code from your application storage
     * @return string|null
     */
    public function getAuthorizationCode();

    /**
     * Get access token from your application storage
     * @return string|null
     */
    public function getAccessToken();

    /**
     * Get administration id from application storage
     * @return string|null
     */
    public function getAdministrationId();
}