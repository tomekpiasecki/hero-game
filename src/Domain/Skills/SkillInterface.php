<?php

namespace Tpiasecki\HeroGame\Domain\Skills;

interface SkillInterface
{
    /**
     * Reduces the taken damage (if applicable for given skill)
     *
     * @param int $damage
     * @return int damage adjusted (reduced) by the skill
     */
    public function reduceDamage(int $damage): int;

    /**
     * Determines whether character is allowed to attack two times in a row
     *
     * @return bool
     */
    public function shouldAttackAgain(): bool;
}
