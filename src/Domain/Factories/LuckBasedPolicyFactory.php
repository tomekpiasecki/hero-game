<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Policies\LuckBasedSelectionPolicy;
use Tpiasecki\HeroGame\Domain\Policies\NotAbleToSelectAttackerException;

class LuckBasedPolicyFactory
{
    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @return LuckBasedSelectionPolicy
     * @throws NotAbleToSelectAttackerException
     */
    public function createPolicy(CharacterInterface $player1, CharacterInterface $player2): LuckBasedSelectionPolicy
    {
        return new LuckBasedSelectionPolicy($player1, $player2);
    }
}
