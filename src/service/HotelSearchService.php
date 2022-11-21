<?php

namespace XLR8RMS\App\Service;

use Closure;
use Exception;
use Illuminate\Support\Collection;
use XLR8RMS\App\Entity\Hotel;
use XLR8RMS\App\Entity\Point;
use XLR8RMS\App\Enums\OrderBy;
use XLR8RMS\App\Enums\Unit;
use XLR8RMS\App\Interfaces\Repository;
use XLR8RMS\App\Interfaces\CalculateDistanceAlgorithm;
use XLR8RMS\App\Strategy\AngularDegreesMeasuring;

class HotelSearchService
{
    private Repository $repository;
    
    private point $chosenPoint;
    private Closure $sortFn;
    
    private CalculateDistanceAlgorithm $algorithm;
    
    /**
     * HotelSearchService constructor
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Get nearby hotels by some latitude and longitude point
     *
     * @param float $latitude
     * @param float $longitude
     * @param int   $orderBy
     *
     * @return Collection
     * @throws Exception
     */
    public function getNearbyHotels(float $latitude, float $longitude, int $orderBy = OrderBy::PROXIMITY): Collection
    {
        return $this->setChosenPoint($latitude, $longitude)
            ->setOrderByFunction($orderBy)
            ->setCalculateDistanceAlgorithm(new AngularDegreesMeasuring)
            ->filterForNearbyHotels();
    }
    
    /**
     * Set chosen point location
     *
     * @param float $latitude
     * @param float $longitude
     *
     * @return $this
     */
    private function setChosenPoint(float $latitude, float $longitude): HotelSearchService
    {
        $this->chosenPoint = new Point($latitude, $longitude);
        
        return $this;
    }
    
    /**
     * Set order by function
     *
     * @param int $orderBy
     *
     * @return $this
     * @throws Exception
     */
    private function setOrderByFunction(int $orderBy): HotelSearchService
    {
        if (!in_array($orderBy, [OrderBy::PROXIMITY, OrderBy::PRICE_PER_NIGHT])) {
            throw new Exception("Unsupported order by!");
        }

        if ($orderBy === OrderBy::PRICE_PER_NIGHT) {
            $this->sortFn = function (Hotel $hotelA, Hotel $hotelB) {
                $this->calculateHotelDistanceFromChosenPoint($hotelA);
                $this->calculateHotelDistanceFromChosenPoint($hotelB);
                
                if ($hotelA->getPricePerNight() === $hotelB->getPricePerNight()) {
                    return 0;
                }

                return $hotelA->getPricePerNight() > $hotelB->getPricePerNight() ? 1 : -1;
            };
        } else {
            $this->sortFn = function (Hotel $hotelA, Hotel $hotelB) {
                $this->calculateHotelDistanceFromChosenPoint($hotelA);
                $this->calculateHotelDistanceFromChosenPoint($hotelB);
            
                if ($hotelA->getDistance() === $hotelB->getDistance()) {
                    return 0;
                }
            
                return $hotelA->getDistance() > $hotelB->getDistance() ? 1 : -1;
            };
        }
    
        return $this;
    }
    
    /**
     * Set calculate distance algorithm
     *
     * @param CalculateDistanceAlgorithm $algorithm
     *
     * @return HotelSearchService
     */
    private function setCalculateDistanceAlgorithm(CalculateDistanceAlgorithm $algorithm): HotelSearchService
    {
        $this->algorithm = $algorithm;
        
        return $this;
    }
    
    /**
     * Filter nearby hotels
     *
     * @return Collection
     */
    private function filterForNearbyHotels(): Collection
    {
        return $this->getAllHotels()
            ->sort($this->sortFn)
            ->map(fn (Hotel $hotel) => "{$hotel->getName()}, {$hotel->getDistance()} KM, {$hotel->getPricePerNight()} EUR");
    }
    
    /**
     * Calculate hotel distance from the current latitude and longitude point
     *
     * @param Hotel $hotel
     *
     * @return void
     */
    private function calculateHotelDistanceFromChosenPoint(Hotel &$hotel): void
    {
        $hotelPoint = new Point($hotel->getLatitude(), $hotel->getLongitude());

        $distance = $this->algorithm->calculate($this->chosenPoint, $hotelPoint, Unit::KM);
    
        $hotel->setDistance($distance);
    }
    
    /**
     * Get all hotels
     *
     * @return Collection
     */
    private function getAllHotels(): Collection
    {
        return $this->repository->getItems();
    }

}