<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Battle;
use Tpiasecki\HeroGame\Domain\BattleInterface;
use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;

class BattleFactory implements BattleFactoryInterface
{
    /**
     * @var AttackerSelectionPolicyFactoryInterface
     */
    private $attackerSelectionPolicyFactory;

    /**
     * @var TurnFactoryInterface
     */
    private $turnFactory;

    /**
     * @param AttackerSelectionPolicyFactoryInterface $attackerSelectionPolicyFactory
     * @param TurnFactoryInterface $turnFactory
     */
    public function __construct(
        AttackerSelectionPolicyFactoryInterface $attackerSelectionPolicyFactory,
        TurnFactoryInterface $turnFactory
    ) {
        $this->attackerSelectionPolicyFactory = $attackerSelectionPolicyFactory;
        $this->turnFactory = $turnFactory;
    }

    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @return BattleInterface
     */
    public function createBattle(CharacterInterface $player1, CharacterInterface $player2): BattleInterface
    {
        $attackerSelectionPolicy = $this->attackerSelectionPolicyFactory->createPolicy($player1, $player2);
        return new Battle($player1, $player2, $attackerSelectionPolicy, $this->turnFactory);
    }
}
