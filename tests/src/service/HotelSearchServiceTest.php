<?php

namespace Tests\Src\Service;

use Exception;
use Illuminate\Support\Collection;
use XLR8RMS\App\Enums\OrderBy;
use XLR8RMS\App\Interfaces\Repository;
use XLR8RMS\App\Service\HotelSearchService;
use Tests\Fixtures\HotelRepositoryFixtures;

class HotelSearchServiceTest extends \PHPUnit\Framework\TestCase {
    /**
     * @throws Exception
     */
    public function testGetNearbyHotelsOrderByProximity() {
        $fakeRepository = new class implements Repository {
            public function getItems(): Collection {
                return HotelRepositoryFixtures::getPayload();
            }
        };

        $service = new HotelSearchService($fakeRepository);

        $latitude = 38.74173868542466;
        $longitude = -9.173880017349543;

        $nearbyHotels = $service
            ->getNearbyHotels($latitude, $longitude)
            ->getIterator();
    
        $this->assertSame($nearbyHotels->current(), 'Turim Av Liberdade Hotel, 3.55 KM, 176.25 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Ikkuna Hotel, 21.45 KM, 13.45 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'IGH Eliseos, 475.25 KM, 107.6 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Huckleberries, 1584.51 KM, 67.25 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Huckleberries, 1584.51 KM, 94.15 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Inn on the Lake, 7916.66 KM, 121.05 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Huasteca Secreta, 8476.94 KM, 121.05 EUR');
    }
    
    public function testGetNearbyHotelsOrderByPricePerNight() {
        $fakeRepository = new class implements Repository {
            public function getItems(): Collection {
                return new Collection(HotelRepositoryFixtures::getPayload());
            }
        };
        
        $service = new HotelSearchService($fakeRepository);
        
        $latitude = -0.13395249999996395;
        $longitude = 67.25;
        
        $nearbyHotels = $service
            ->getNearbyHotels($latitude, $longitude, OrderBy::PRICE_PER_NIGHT)
            ->getIterator();
        
        $this->assertSame($nearbyHotels->current(), 'Ikkuna Hotel, 8863.56 KM, 13.45 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Huckleberries, 8479.5 KM, 67.25 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Huckleberries, 8479.5 KM, 94.15 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'IGH Eliseos, 8391.99 KM, 107.6 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Huasteca Secreta, 17129.3 KM, 121.05 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Inn on the Lake, 13012.68 KM, 121.05 EUR');
        $nearbyHotels->next();
        $this->assertSame($nearbyHotels->current(), 'Turim Av Liberdade Hotel, 8840.11 KM, 176.25 EUR');
    }
    
    public function testGetNearbyHotelsOrderByValidation() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unsupported order by!');
        
        $fakeRepository = new class implements Repository {
            public function getItems(): Collection {
                return new Collection(HotelRepositoryFixtures::getPayload());
            }
        };
        
        $service = new HotelSearchService($fakeRepository);
        
        $latitude = -0.13395249999996395;
        $longitude = 67.25;
        
        $service->getNearbyHotels($latitude, $longitude, 1000);
    }
}

