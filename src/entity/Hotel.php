<?php

namespace XLR8RMS\App\Entity;

class Hotel
{
    /**
     * Hotel name
     *
     * @var string $name
     */
    public string $name;
    
    /**
     * Hotel latitude
     *
     * @var float
     */
    private float $latitude;
    
    /**
     * Hotel longitude
     *
     * @var float
     */
    private float $longitude;
    
    /**
     * Hotel price per night
     *
     * @var float
     */
    private float $pricingPerNight;
    
    /**
     * Hotel distance
     *
     * @var float
     */
    private float $distance;
    
    /**
     * Hotel constructor
     *
     * @param string $name
     * @param string  $latitude
     * @param string  $longitude
     * @param string  $pricingPerNight
     */
    public function __construct(string $name, string $latitude, string $longitude, string $pricingPerNight)
    {
        $this->name = $name;
        $this->latitude = (float) $latitude;
        $this->longitude = (float) $longitude;
        $this->pricingPerNight = (float) $pricingPerNight;
    }
    
    /**
     * Get hotel name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Get hotel latitude
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }
    
    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }
    
    /**
     * Get pricing per night
     *
     * @return float
     */
    public function getPricePerNight(): float
    {
        return $this->pricingPerNight;
    }
    
    /**
     * Get distance
     *
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }
    
    /**
     * Set distance
     *
     * @param float $distance
     *
     * @return void
     */
    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }
}
