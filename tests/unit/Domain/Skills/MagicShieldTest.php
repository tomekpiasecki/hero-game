<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Skills;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Tpiasecki\HeroGame\Domain\Skills\MagicShield;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

class MagicShieldTest extends TestCase
{
    public function testShouldAttackAgainReturnsFalseIfProbabilityConditionIsMet(): void
    {
        $this->assertFalse($this->getInstance(15)->shouldAttackAgain());
    }

    public function testShouldAttackAgainReturnsFalseIfProbabilityConditionIsNotMet(): void
    {
        $this->assertFalse($this->getInstance(50)->shouldAttackAgain());
    }

    /**
     * @dataProvider getDamageValues
     */
    public function testDamageGetsReducedIfProbabilityConditionIsMet(int $damage): void
    {
        $expected = (int) ($damage / 2);
        $result = $this->getInstance(10)->reduceDamage($damage);
        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider getDamageValues
     */
    public function testDamageIsNotReducedIfProbabilityConditionIsNotMet(int $damage): void
    {
        $this->assertSame($damage, $this->getInstance(50)->reduceDamage($damage));
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

    private function getInstance($luckyDrawValue = 0): MagicShield
    {
        $randomnessProvider = $this->prophesize(RandomnessProviderInterface::class);
        $randomnessProvider->randomInt(Argument::any(), Argument::any())->willReturn($luckyDrawValue);
        $randomnessProvider = $randomnessProvider->reveal();
        return new MagicShield($randomnessProvider);
    }
}
