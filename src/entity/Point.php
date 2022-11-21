<?php

namespace XLR8RMS\App\Entity;

class Point
{
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
     * Point constructor
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
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
}
