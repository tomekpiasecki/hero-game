<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Policies;

interface DamageCalculationPolicyInterface
{
    /**
     * @return int
     */
    public function calculateDamage(): int;
}
