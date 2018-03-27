<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Policies;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;

class DamageCalculationPolicy implements DamageCalculationPolicyInterface
{
    /**
     * @var CharacterInterface
     */
    private $attacker;

    /**
     * @var CharacterInterface
     */
    private $defender;

    /**
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     */
    public function __construct(CharacterInterface $attacker, CharacterInterface $defender)
    {
        $this->attacker = $attacker;
        $this->defender = $defender;
    }

    /**
     * @return int
     */
    public function calculateDamage(): int
    {
        if ($this->isMishit()) {
            return 0;
        }

        $damage = $this->attacker->getStrength() - $this->defender->getDefence();
        foreach ($this->defender->getSkills() as $skill) {
            $damage = $skill->reduceDamage($damage);
        }

        return $damage;
    }

    /**
     * @return bool
     */
    private function isMishit(): bool
    {
        return $this->defender->isLucky();
    }
}
