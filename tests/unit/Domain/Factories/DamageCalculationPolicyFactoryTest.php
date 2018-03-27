<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\DamageCalculationPolicyFactory;
use Tpiasecki\HeroGame\Domain\Policies\DamageCalculationPolicyInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;

class DamageCalculationPolicyFactoryTest extends TestCase
{
    public function testCreatesPolicy(): void
    {
        $loggerMock = $this->prophesize(BattleLoggerInterface::class)->reveal();
        $attackerMock = $this->prophesize(CharacterInterface::class)->reveal();
        $defenderMock = $this->prophesize(CharacterInterface::class)->reveal();

        $factory = new DamageCalculationPolicyFactory($loggerMock);
        $policy = $factory->createCalculationPolicy($attackerMock, $defenderMock);

        $this->assertInstanceOf(DamageCalculationPolicyInterface::class, $policy);
    }
}
