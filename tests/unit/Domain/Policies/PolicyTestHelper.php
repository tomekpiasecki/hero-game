<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Policies;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;

class PolicyTestHelper extends TestCase
{
    public function getPlayer(int $speed = 0, int $luck = 0): CharacterInterface
    {
        $player1Mock = $this->prophesize(CharacterInterface::class);
        $player1Mock->getSpeed()->willReturn($speed);
        $player1Mock->getLuck()->willReturn($luck);

        return $player1Mock->reveal();
    }
}
