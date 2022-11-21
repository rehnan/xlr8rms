<?php

namespace XLR8RMS\App\Interfaces;

use XLR8RMS\App\Entity\Point;

interface CalculateDistanceAlgorithm
{
    public function calculate(Point $pointA, Point $pointB, int $unit): float;
}