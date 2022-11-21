<?php
    
namespace XLR8RMS\App\Strategy;
    
use XLR8RMS\App\Entity\Point;
use XLR8RMS\App\Enums\Unit;
use XLR8RMS\App\Interfaces\CalculateDistanceAlgorithm;

class AngularDegreesMeasuring implements CalculateDistanceAlgorithm
{
    public function calculate(Point $pointA, Point $pointB, int $unit): float
    {
        $theta = $pointA->getLongitude() - $pointB->getLongitude();
        
        $distance = (sin(deg2rad($pointA->getLatitude())) * sin(deg2rad($pointB->getLatitude()))) + (cos(deg2rad($pointA->getLatitude())) * cos(deg2rad($pointB->getLatitude())) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        
        if ($unit === Unit::KM) {
            $distance = $distance * 1.609344;
        }
        
        return round($distance,2);
    }
}