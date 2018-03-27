<?php

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\TurnInterface;

interface TurnFactoryInterface
{
    /**
     * Creates Turn object
     *
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @return TurnInterface
     */
    public function createTurn(CharacterInterface $attacker, CharacterInterface $defender): TurnInterface;
}
