<?php

namespace Tpiasecki\HeroGame\Domain\Policies;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;

interface AttackerSelectionPolicyInterface
{
    public function getAttacker(): CharacterInterface;
    public function getDefender(): CharacterInterface;
}
