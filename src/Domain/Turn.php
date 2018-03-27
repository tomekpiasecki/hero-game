<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\DamageCalculationPolicyFactoryInterface;

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
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @param DamageCalculationPolicyFactoryInterface $damageCalculationPolicyFactory
     */
    public function __construct(
        CharacterInterface $attacker,
        CharacterInterface $defender,
        DamageCalculationPolicyFactoryInterface $damageCalculationPolicyFactory
    ) {
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->damageCalculationPolicyFactory = $damageCalculationPolicyFactory;
    }

    public function doTurn(): void //TODO check
    {
        var_dump("{$this->attacker->getName()} attacs");
        $this->strike();

        if (!$this->shouldStrikeAgain()) {
            return;
        }

        var_dump("?! ?! ?! {$this->attacker->getName()} strikes again");

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
            var_dump("!!! oh no {$this->attacker->getName()} misses");
        } else {
            $this->defender->applyDamage($damage);
            var_dump("{$this->defender->getName()} looses $damage of health {$this->defender->getHealth()} remains");
        }
    }

    /**
     * Determines whether attacker should strike again in current turn
     *
     * @return bool
     */
    private function shouldStrikeAgain(): bool
    {
        if (!$this->defender->isAlive()) {
            return false;
        }

        foreach ($this->attacker->getSkills() as $skill) {
            if ($skill->shouldAttackAgain()) {
                return true;
            }
        }

        return false;
    }
}
