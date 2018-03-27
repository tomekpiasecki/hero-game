<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Infrastructure;

class RandomnessProvider implements RandomnessProviderInterface
{
    public function randomInt(int $min, int $max): int
    {
        try {
            return random_int($min, $max);
        } catch (\Exception $ex) {
            return rand($min, $max);
        }
    }
}
