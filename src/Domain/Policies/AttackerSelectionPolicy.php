<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Policies;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\LuckBasedPolicyFactory;
use Tpiasecki\HeroGame\Domain\Factories\SpeedBasedPolicyFactory;

class AttackerSelectionPolicy implements AttackerSelectionPolicyInterface
{
    /**
     * @var CharacterInterface
     */
    private $player1;

    /**
     * @var CharacterInterface
     */
    private $player2;

    /**
     * @var SpeedBasedPolicyFactory
     */
    private $speedBasedPolicyFactory;

    /**
     * @var LuckBasedPolicyFactory
     */
    private $luckBasedPolicyFactory;

    /**
     * @var CharacterInterface
     */
    private $attacker;

    /**
     * @var CharacterInterface
     */
    private $defender;

    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @param SpeedBasedPolicyFactory $speedBasedPolicyFactory
     * @param LuckBasedPolicyFactory $luckBasedPolicyFactory
     */
    public function __construct(
        CharacterInterface $player1,
        CharacterInterface $player2,
        SpeedBasedPolicyFactory $speedBasedPolicyFactory,
        LuckBasedPolicyFactory $luckBasedPolicyFactory
    ) {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->speedBasedPolicyFactory = $speedBasedPolicyFactory;
        $this->luckBasedPolicyFactory = $luckBasedPolicyFactory;

        $this->selectAttacker();
    }

    /**
     * @return CharacterInterface
     */
    public function getAttacker(): CharacterInterface
    {
        return $this->attacker;
    }

    /**
     * @return CharacterInterface
     */
    public function getDefender(): CharacterInterface
    {
        return $this->defender;
    }

    /**
     * Selects player that should start the first tour
     */
    private function selectAttacker(): void
    {
        try {
            $speedPolicy = $this->speedBasedPolicyFactory->createPolicy($this->player1, $this->player2);
            $this->attacker = $speedPolicy->getAttacker();
            $this->defender = $speedPolicy->getDefender();
        } catch (NotAbleToSelectAttackerException $ex) {
        }

        try {
            $luckPolicy = $this->luckBasedPolicyFactory->createPolicy($this->player1, $this->player2);
            $this->attacker = $luckPolicy->getAttacker();
            $this->defender = $luckPolicy->getDefender();
        } catch (NotAbleToSelectAttackerException $ex) {
            $this->attacker = $this->player2;
            $this->defender = $this->player1;
        }
    }
}
