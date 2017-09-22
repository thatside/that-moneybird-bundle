<?php


namespace Thatside\MoneybirdBundle\Services;

/**
 * Class ThatMoneybirdCodeFetcherDummyService
 * Dummy service that should be redefined
 */
class ThatMoneybirdCodeFetcherDummyService implements CodeFetcherInterface
{
    const AUTH_CODE = 'AUTHORIZATION_CODE';
    const AUTH_TOKEN = 'AUTHORIZATION_TOKEN';
    const ADMINISTRATION_ID = 'ADMINISTRATION_ID';

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationCode()
    {
        return self::AUTH_CODE;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken()
    {
        return self::AUTH_TOKEN;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdministrationId()
    {
        return self::ADMINISTRATION_ID;
    }
}