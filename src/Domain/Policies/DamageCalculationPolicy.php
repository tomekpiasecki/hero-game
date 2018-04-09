<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Policies;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;

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
     * @var BattleLoggerInterface
     */
    private $logger;

    /**
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @param BattleLoggerInterface $logger
     */
    public function __construct(
        CharacterInterface $attacker,
        CharacterInterface $defender,
        BattleLoggerInterface $logger
    ) {
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->logger = $logger;
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
        $damage = $damage >= 0 ? $damage : 0;

        return $this->applyDefenderSkills($damage);
    }

    /**
     * @param int $damage
     * @return int damage modified by defender skills
     */
    private function applyDefenderSkills(int $damage) : int
    {
        $reducedDamage = $damage;
        foreach ($this->defender->getSkills() as $skill) {
            $reducedDamage = $skill->reduceDamage($reducedDamage);
            if ($reducedDamage < $damage) {
                $this->logger->logDamageReduction(
                    $this->defender->getName(),
                    $skill->getName(),
                    $damage - $reducedDamage
                );
            }
        }

        return $reducedDamage;
    }

    /**
     * @return bool
     */
    private function isMishit(): bool
    {
        return $this->defender->isLucky();
    }
}
