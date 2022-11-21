<?php

namespace Tests\Src\Repository;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\Fixtures\HotelRepositoryFixtures;
use XLR8RMS\App\Repository\HotelAPIRepository;

class HotelAPIRepositoryTest extends \PHPUnit\Framework\TestCase {
    
    private function getClientRestMockInstance(): Client
    {
        $response1Mock = new Response(
            200,
            ['Content-Type' => 'application/json'],
            HotelRepositoryFixtures::getRawPayloadSource1()
        );
    
        $response2Mock = new Response(
            200,
            ['Content-Type' => 'application/json'],
            HotelRepositoryFixtures::getRawPayloadSource2()
        );
    
        $mockHandler = new MockHandler([$response1Mock, $response2Mock]);
        
        return new Client(['handler' => HandlerStack::create($mockHandler)]);
    }
    
    public function testLoadSourcingDataSuccessfully() {
        
        $clientMock = $this->getClientRestMockInstance();
    
        $source1 = json_decode(HotelRepositoryFixtures::getRawPayloadSource1());
        $source2 = json_decode(HotelRepositoryFixtures::getRawPayloadSource2());
        
        $totalRecords = count(data_get($source1, 'message')) + count(data_get($source2, 'message'));

        $sources = [
            'http://source-repo-1/source.json',
            'http://source-repo-2/source.json'
        ];
        
        $hotelAPIRepository = new HotelAPIRepository($sources, $clientMock);

        $this->assertSame($hotelAPIRepository->getItems()->count(), $totalRecords);
    }
}

