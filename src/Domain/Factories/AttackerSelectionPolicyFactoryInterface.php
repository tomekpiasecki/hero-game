<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Policies\AttackerSelectionPolicyInterface;

interface AttackerSelectionPolicyFactoryInterface
{
    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @return AttackerSelectionPolicyInterface
     */
    public function createPolicy(
        CharacterInterface $player1,
        CharacterInterface $player2
    ): AttackerSelectionPolicyInterface;
}
