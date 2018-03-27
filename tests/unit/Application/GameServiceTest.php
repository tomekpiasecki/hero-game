<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Application;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Tpiasecki\HeroGame\Application\GameService;
use Tpiasecki\HeroGame\Domain\BattleInterface;
use Tpiasecki\HeroGame\Domain\Characters\Beast;
use Tpiasecki\HeroGame\Domain\Characters\Hero;
use Tpiasecki\HeroGame\Domain\Factories\BattleFactoryInterface;
use Tpiasecki\HeroGame\Domain\Factories\BeastFactory;
use Tpiasecki\HeroGame\Domain\Factories\HeroFactory;

class GameServiceTest extends TestCase
{
    public function testStartsGame(): void
    {
        $heroMock = $this->prophesize(Hero::class)->reveal();
        $heroFactoryMock = $this->prophesize(HeroFactory::class);
        $heroFactoryMock->createFromName(Argument::any())->willReturn($heroMock);

        $beastMock = $this->prophesize(Beast::class)->reveal();
        $beastFactoryMock = $this->prophesize(BeastFactory::class);
        $beastFactoryMock->createFromName(Argument::any())->willReturn($beastMock);

        $battleMock = $this->prophesize(BattleInterface::class);
        $battleMock->start()->shouldBeCalled();
        $battleMock = $battleMock->reveal();
        $battleFactoryMock = $this->prophesize(BattleFactoryInterface::class);
        $battleFactoryMock->createBattle(Argument::any(), Argument::any())->willReturn($battleMock);

        $game = new GameService($heroFactoryMock->reveal(), $beastFactoryMock->reveal(), $battleFactoryMock->reveal());
        $game->startGame();
    }
}
