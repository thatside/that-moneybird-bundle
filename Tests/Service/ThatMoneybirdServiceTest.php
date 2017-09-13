<?php


namespace Thatside\MoneybirdBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Thatside\MoneybirdBundle\Services\ThatMoneybirdCodeFetcherDummyService;
use Thatside\MoneybirdBundle\Services\ThatMoneybirdService;
use Picqer\Financials\Moneybird\Connection;

class ThatMoneybirdServiceTest extends TestCase
{
    public function testServiceConstructor()
    {
        $connectionMock = $this->createMock(Connection::class);
        
        $codeFetcher = new ThatMoneybirdCodeFetcherDummyService();
        $eventDispatcher = $this->createMock(EventDispatcher::class);
        $eventDispatcher->method('dispatch');
        
        $connectionMock->expects($this->once())->method('setAuthorizationCode')->with($this->equalTo(ThatMoneybirdCodeFetcherDummyService::AUTH_CODE));
        $connectionMock->expects($this->once())->method('setAccessToken')->with($this->equalTo(ThatMoneybirdCodeFetcherDummyService::AUTH_TOKEN));
        
        $connectionMock->expects($this->once())->method('connect');
 
        $connectionMock->expects($this->once())->method('getAccessToken')->willReturn(ThatMoneybirdCodeFetcherDummyService::AUTH_TOKEN);
        
        $mb = new ThatMoneybirdService($connectionMock, $codeFetcher, $eventDispatcher);

        
        $this->assertTrue($mb->isMoneybirdEnabled());
    }
    
    public function testServiceConstructorMoneybirdUnavailable()
    {
        $connectionMock = $this->createMock(Connection::class);
        
        $codeFetcher = new ThatMoneybirdCodeFetcherDummyService();  
        $eventDispatcher = $this->createMock(EventDispatcher::class);
        $eventDispatcher->method('dispatch');
        
        $connectionMock->expects($this->once())->method('setAuthorizationCode')->with($this->equalTo(ThatMoneybirdCodeFetcherDummyService::AUTH_CODE));
        $connectionMock->expects($this->once())->method('setAccessToken')->with($this->equalTo(ThatMoneybirdCodeFetcherDummyService::AUTH_TOKEN));
        
        $connectionMock->expects($this->once())->method('connect')->willThrowException(new \Exception());
        
        $connectionMock->expects($this->never())->method('getAccessToken')->willReturn(ThatMoneybirdCodeFetcherDummyService::AUTH_TOKEN);
        
        $this->expectException(\Exception::class);
        $mb = new ThatMoneybirdService($connectionMock, $codeFetcher, $eventDispatcher);
    }
}