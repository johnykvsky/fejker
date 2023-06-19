<?php

declare(strict_types=1);

namespace Fejker\Core;

use Fejker\Extension\Extension;

class Coordinates implements Extension
{
    public function latitude(float $min = -90.0, float $max = 90.0): float
    {
        if ($min < -90 || $max < -90) {
            throw new \LogicException('Latitude cannot be less that -90.0');
        }

        if ($min > 90 || $max > 90) {
            throw new \LogicException('Latitude cannot be greater that 90.0');
        }

        return $this->randomFloat(6, $min, $max);
    }

    public function longitude(float $min = -180.0, float $max = 180.0): float
    {
        if ($min < -180 || $max < -180) {
            throw new \LogicException('Longitude cannot be less that -180.0');
        }

        if ($min > 180 || $max > 180) {
            throw new \LogicException('Longitude cannot be greater that 180.0');
        }

        return $this->randomFloat(6, $min, $max);
    }

    public function localCoordinates(): array
    {
        return [
            'latitude' => $this->latitude(),
            'longitude' => $this->longitude(),
        ];
    }

    private function randomFloat(int $nbMaxDecimals, float $min, float $max): float
    {
        if ($min > $max) {
            throw new \LogicException('Invalid coordinates boundaries');
        }

        return round($min + mt_rand() / mt_getrandmax() * ($max - $min), $nbMaxDecimals);
    }
}
