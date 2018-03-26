<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Policies\NotAbleToSelectAttackerException;
use Tpiasecki\HeroGame\Domain\Policies\SpeedBasedSelectionPolicy;

class SpeedBasedPolicyFactory
{
    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @return SpeedBasedSelectionPolicy
     * @throws NotAbleToSelectAttackerException
     */
    public function createPolicy(CharacterInterface $player1, CharacterInterface $player2): SpeedBasedSelectionPolicy
    {
        return new SpeedBasedSelectionPolicy($player1, $player2);
    }
}
