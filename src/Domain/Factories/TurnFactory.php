<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Turn;
use Tpiasecki\HeroGame\Domain\TurnInterface;

class TurnFactory implements TurnFactoryInterface
{
    /**
     * @var DamageCalculationPolicyFactoryInterface
     */
    private $damageCalculationPolicyFactory;

    /**
     * @param DamageCalculationPolicyFactoryInterface $damageCalculationPolicyFactory
     */
    public function __construct(DamageCalculationPolicyFactoryInterface $damageCalculationPolicyFactory)
    {
        $this->damageCalculationPolicyFactory = $damageCalculationPolicyFactory;
    }

    /**
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @return TurnInterface
     */
    public function createTurn(CharacterInterface $attacker, CharacterInterface $defender): TurnInterface
    {
        return new Turn($attacker, $defender, $this->damageCalculationPolicyFactory);
    }
}
