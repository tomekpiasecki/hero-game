<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\TurnFactoryInterface;
use Tpiasecki\HeroGame\Domain\Policies\AttackerSelectionPolicyInterface;

class Battle implements BattleInterface
{
    const TURNS_LIMIT = 20;

    /**
     * @var CharacterInterface
     */
    private $player1;

    /**
     * @var CharacterInterface
     */
    private $player2;

    /**
     * @var int
     */
    private $numberOfTurns = 0;

    /**
     * @var AttackerSelectionPolicyInterface
     */
    private $attackerSelectionPolicy;

    /**
     * @var TurnFactoryInterface
     */
    private $turnFactory;

    /**
     * @var CharacterInterface
     */
    private $currentAttacker;

    /**
     * @var CharacterInterface
     */
    private $currentDefender;

    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @param AttackerSelectionPolicyInterface $attackerSelectionPolicy
     * @param TurnFactoryInterface $turnFactory
     */
    public function __construct(
        CharacterInterface $player1,
        CharacterInterface $player2,
        AttackerSelectionPolicyInterface $attackerSelectionPolicy,
        TurnFactoryInterface $turnFactory
    ) {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->attackerSelectionPolicy = $attackerSelectionPolicy;
        $this->turnFactory = $turnFactory;
        var_dump("p1 {$this->player1->getName()} luck {$this->player1->getLuck()} p1 health {$this->player1->getHealth()} p1 strength {$this->player1->getStrength()} defence {$this->player1->getDefence()}"); //TODO remove
        var_dump("p2 {$this->player2->getName()} luck {$this->player2->getLuck()} p1 health {$this->player2->getHealth()} p1 strength {$this->player2->getStrength()} defence {$this->player2->getDefence()}"); //TODO remove
    }

    public function start(): void
    {
        while ($this->canContinue()) {
            $this->doTurn();
        }

        $this->displayResult();
    }

    /**
     * Checks if battle can be continued
     *
     * @return bool
     */
    private function canContinue(): bool
    {
        return !$this->isLimitOfTurnsReached() && $this->areBothPlayersAlive();
    }

    /**
     * @return bool
     */
    private function isLimitOfTurnsReached(): bool
    {
        return $this->numberOfTurns === self::TURNS_LIMIT;
    }

    /**
     * @return bool
     */
    private function areBothPlayersAlive(): bool
    {
        return $this->player1->isAlive() && $this->player2->isAlive();
    }

    /**
     * Performs single turn
     */
    public function doTurn(): void
    {
        $this->numberOfTurns++;
        var_dump('`````````````````````````````````````');
        var_dump("Turn {$this->numberOfTurns} begins");

        $turn = $this->turnFactory->createTurn($this->getCurrentAttacker(), $this->getCurrentDefender());
        $turn->doTurn();

        var_dump("Turn {$this->numberOfTurns} ends");
    }

    /**
     * Selects attacker for current turn
     *
     * @return CharacterInterface
     */
    private function getCurrentAttacker(): CharacterInterface
    {
        if ($this->numberOfTurns === 1) {
            $this->currentAttacker = $this->attackerSelectionPolicy->getAttacker();
        } else {
            $this->currentAttacker = $this->currentAttacker->equals($this->player1) ?
                $this->player2 :
                $this->player1;
        }

        return $this->currentAttacker;
    }

    /**
     * Selects defender for current turn
     *
     * @return CharacterInterface
     */
    private function getCurrentDefender(): CharacterInterface
    {
        if ($this->numberOfTurns === 1) {
            $this->currentDefender = $this->attackerSelectionPolicy->getDefender();
        } else {
            $this->currentDefender = $this->currentDefender->equals($this->player1) ?
                $this->player2 :
                $this->player1;
        }

        return $this->currentDefender;
    }

    private function displayResult(): void //TODO rethink name, finish
    {
        if ($this->isLimitOfTurnsReached()) {
            var_dump("Limit of turns reached");
        } elseif (!$this->areBothPlayersAlive()) {
            var_dump("One of players is dead");
        }

        $winner = $this->player1->getHealth() > $this->player2->getHealth() ?
            $this->player1 :
            $this->player2;

        var_dump("The winner is {$winner->getName()}");
    }
}
