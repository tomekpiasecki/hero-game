<?php

namespace Tpiasecki\HeroGame\Domain\Policies;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;

interface AttackerSelectionPolicyInterface
{
    /**
     * @return CharacterInterface
     */
    public function getAttacker(): CharacterInterface;

    /**
     * @return CharacterInterface
     */
    public function getDefender(): CharacterInterface;
}
