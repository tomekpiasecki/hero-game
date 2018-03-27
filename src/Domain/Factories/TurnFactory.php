<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Turn;
use Tpiasecki\HeroGame\Domain\TurnInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;

class TurnFactory implements TurnFactoryInterface
{
    /**
     * @var DamageCalculationPolicyFactoryInterface
     */
    private $damageCalculationPolicyFactory;

    /**
     * @var BattleLoggerInterface
     */
    private $logger;

    /**
     * @param DamageCalculationPolicyFactoryInterface $damageCalculationPolicyFactory
     * @param BattleLoggerInterface $logger
     */
    public function __construct(
        DamageCalculationPolicyFactoryInterface $damageCalculationPolicyFactory,
        BattleLoggerInterface $logger
    ) {
        $this->damageCalculationPolicyFactory = $damageCalculationPolicyFactory;
        $this->logger = $logger;
    }

    /**
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @return TurnInterface
     */
    public function createTurn(CharacterInterface $attacker, CharacterInterface $defender): TurnInterface
    {
        return new Turn($attacker, $defender, $this->damageCalculationPolicyFactory, $this->logger);
    }
}
