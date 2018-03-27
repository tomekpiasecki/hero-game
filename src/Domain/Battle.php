<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\TurnFactoryInterface;
use Tpiasecki\HeroGame\Domain\Policies\AttackerSelectionPolicyInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;

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
     * @var BattleLoggerInterface
     */
    private $logger;

    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @param AttackerSelectionPolicyInterface $attackerSelectionPolicy
     * @param TurnFactoryInterface $turnFactory
     * @param BattleLoggerInterface $logger
     */
    public function __construct(
        CharacterInterface $player1,
        CharacterInterface $player2,
        AttackerSelectionPolicyInterface $attackerSelectionPolicy,
        TurnFactoryInterface $turnFactory,
        BattleLoggerInterface $logger
    ) {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->attackerSelectionPolicy = $attackerSelectionPolicy;
        $this->turnFactory = $turnFactory;
        $this->logger = $logger;
    }

    public function start(): void
    {
        $this->logger->logBattleStart($this->player1->getName(), $this->player2->getName());

        while ($this->canContinue()) {
            $this->doTurn();
        }

        $this->logResult();
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
        $this->logger->logTurnStart($this->numberOfTurns);

        $turn = $this->turnFactory->createTurn($this->getCurrentAttacker(), $this->getCurrentDefender());
        $turn->doTurn();

        $this->logger->logTurnEnd($this->numberOfTurns);
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

    private function logResult(): void
    {
        if ($this->isLimitOfTurnsReached()) {
            $this->logger->logMessage("Limit of turns reached");
        }

        $winner = $this->player1->getHealth() > $this->player2->getHealth() ?
            $this->player1 :
            $this->player2;

        $this->logger->declareWinner($winner->getName());
    }
}
