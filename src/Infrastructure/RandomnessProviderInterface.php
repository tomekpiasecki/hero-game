<?php

namespace Tpiasecki\HeroGame\Infrastructure;

interface RandomnessProviderInterface
{
    /**
     * Generates random int for given range
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    public function randomInt(int $min, int $max): int;
}
