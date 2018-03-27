<?php

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\BattleInterface;
use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;

interface BattleFactoryInterface
{
    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @return BattleInterface
     */
    public function createBattle(CharacterInterface $player1, CharacterInterface $player2): BattleInterface;
}
