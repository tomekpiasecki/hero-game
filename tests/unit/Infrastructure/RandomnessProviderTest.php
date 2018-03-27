<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Infrastructure;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProvider;

class RandomnessProviderTest extends TestCase
{
    /**
     * @dataProvider getInputRanges
     */
    public function testReturnsIntFromGivenRange(int $min, int $max): void
    {
        $provider = new RandomnessProvider();
        $result = $provider->randomInt($min, $max);

        $this->assertGreaterThanOrEqual($min, $result);
        $this->assertLessThanOrEqual($max, $result);
    }

    public function getInputRanges(): array
    {
        return [
            [1, 7],
            [2, 18],
            [25, 30],
            [28, 36],
            [44, 56],
            [60, 90],
            [70, 100]
        ];
    }
}
