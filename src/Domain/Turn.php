<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\DamageCalculationPolicyFactoryInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;

class Turn implements TurnInterface
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
     * @var DamageCalculationPolicyFactoryInterface
     */
    private $damageCalculationPolicyFactory;

    /**
     * @var BattleLoggerInterface
     */
    private $logger;

    /**
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @param DamageCalculationPolicyFactoryInterface $damageCalculationPolicyFactory
     * @param BattleLoggerInterface $logger
     */
    public function __construct(
        CharacterInterface $attacker,
        CharacterInterface $defender,
        DamageCalculationPolicyFactoryInterface $damageCalculationPolicyFactory,
        BattleLoggerInterface $logger
    ) {
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->damageCalculationPolicyFactory = $damageCalculationPolicyFactory;
        $this->logger = $logger;
    }

    public function doTurn(): void
    {
        $this->logger->logAttack($this->attacker->getName());
        $this->strike();

        if (!$this->shouldStrikeAgain()) {
            return;
        }

        $this->logger->logDoubleStrike($this->attacker->getName());
        $this->strike();
    }

    /**
     * Performs single strike
     */
    private function strike(): void
    {
        $damageCalculationPolicy = $this->damageCalculationPolicyFactory->createCalculationPolicy(
            $this->attacker,
            $this->defender
        );

        $damage = $damageCalculationPolicy->calculateDamage();
        if ($damage == 0) {
            $this->logger->logMiss();
            return;
        }

        $this->defender->applyDamage($damage);
        $this->logger->logHit($this->defender->getName(), $damage, $this->defender->getHealth());
        if (!$this->isDefenderAlive()) {
            $this->logger->logDeath($this->defender->getName());
        }
    }

    /**
     * Determines whether attacker should strike again in current turn
     *
     * @return bool
     */
    private function shouldStrikeAgain(): bool
    {
        if (!$this->isDefenderAlive()) {
            return false;
        }

        foreach ($this->attacker->getSkills() as $skill) {
            if ($skill->shouldAttackAgain()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isDefenderAlive(): bool
    {
        return $this->defender->isAlive();
    }
}
