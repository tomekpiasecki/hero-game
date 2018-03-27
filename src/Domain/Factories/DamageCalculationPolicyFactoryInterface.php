<?php

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Policies\DamageCalculationPolicyInterface;

interface DamageCalculationPolicyFactoryInterface
{
    /**
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @return DamageCalculationPolicyInterface
     */
    public function createCalculationPolicy(
        CharacterInterface $attacker,
        CharacterInterface $defender
    ): DamageCalculationPolicyInterface;
}
