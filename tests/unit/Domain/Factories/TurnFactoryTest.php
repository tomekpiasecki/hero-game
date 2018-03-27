<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\DamageCalculationPolicyFactoryInterface;
use Tpiasecki\HeroGame\Domain\Factories\TurnFactory;
use Tpiasecki\HeroGame\Domain\TurnInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;

class TurnFactoryTest extends TestCase
{
    public function testCreatesTurn(): void
    {
        $loggerMock = $this->prophesize(BattleLoggerInterface::class)->reveal();
        $attackerMock = $this->prophesize(CharacterInterface::class)->reveal();
        $defenderMock = $this->prophesize(CharacterInterface::class)->reveal();
        $policyFactoryMock = $this->prophesize(DamageCalculationPolicyFactoryInterface::class)->reveal();

        $factory = new TurnFactory($policyFactoryMock, $loggerMock);
        $turn = $factory->createTurn($attackerMock, $defenderMock);

        $this->assertInstanceOf(TurnInterface::class, $turn);
    }
}
