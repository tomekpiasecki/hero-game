<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Skills;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Skills\RapidStrike;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

class RapidStrikeTest extends TestCase
{
    /**
     * @dataProvider getDamageValues
     * @param $damage
     */
    public function testReduceDamageDoesntChangeValueIfProbabilityConditionIsMet(int $damage): void
    {
        $this->assertSame($damage, $this->getInstance(5)->reduceDamage($damage));
    }

    /**
     * @dataProvider getDamageValues
     * @param $damage
     */
    public function testReduceDamageDoesntChangeValueIfProbabilityConditionIsNotMet(int $damage): void
    {
        $this->assertSame($damage, $this->getInstance(30)->reduceDamage($damage));
    }

    public function testShouldAttackAgainReturnsTrueIfProbabilityConditionIsMet(): void
    {
        $this->assertTrue($this->getInstance(8)->shouldAttackAgain());
    }

    public function testShouldAttackAgainReturnsFalseIfProbabilityConditionIsNotMet(): void
    {
        $this->assertFalse($this->getInstance(33)->shouldAttackAgain());
    }

    public function getDamageValues(): array
    {
        return [
            [5],
            [9],
            [13],
            [18],
            [25],
            [33],
            [45]
        ];
    }

    public function testNameIsNotEmpty(): void
    {
        $this->assertNotEmpty($this->getInstance()->getName());
    }

    private function getInstance($luckyDrawValue = 0): RapidStrike
    {
        $randomnessProvider = $this->prophesize(RandomnessProviderInterface::class);
        $randomnessProvider->randomInt(1, 100)->willReturn($luckyDrawValue);
        $randomnessProvider = $randomnessProvider->reveal();
        return new RapidStrike($randomnessProvider);
    }
}
