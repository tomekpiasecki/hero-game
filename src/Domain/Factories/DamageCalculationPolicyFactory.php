<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Policies\DamageCalculationPolicy;
use Tpiasecki\HeroGame\Domain\Policies\DamageCalculationPolicyInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;

class DamageCalculationPolicyFactory implements DamageCalculationPolicyFactoryInterface
{
    /**
     * @var BattleLoggerInterface
     */
    private $logger;

    /**
     * @param BattleLoggerInterface $logger
     */
    public function __construct(BattleLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @return DamageCalculationPolicyInterface
     */
    public function createCalculationPolicy(
        CharacterInterface $attacker,
        CharacterInterface $defender
    ): DamageCalculationPolicyInterface {
        return new DamageCalculationPolicy($attacker, $defender, $this->logger);
    }
}
