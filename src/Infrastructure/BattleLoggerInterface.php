<?php

namespace Tpiasecki\HeroGame\Infrastructure;

interface BattleLoggerInterface
{
    /**
     * @param string $player1Name
     * @param string $player2Name
     */
    public function logBattleStart(string $player1Name, string $player2Name): void;

    /**
     * @param int $turnNumber
     */
    public function logTurnStart(int $turnNumber): void;

    /**
     * @param int $turnNumber
     */
    public function logTurnEnd(int $turnNumber): void;

    /**
     * @param string $attackerName
     */
    public function logAttack(string $attackerName): void;

    /**
     * Logs missed strike
     */
    public function logMiss(): void;

    /**
     * @param string $defenderName
     * @param int $damage
     * @param int $remainingHealth
     */
    public function logHit(string $defenderName, int $damage, int $remainingHealth): void;

    /**
     * @param string $attackerName
     */
    public function logDoubleStrike(string $attackerName): void;

    /**
     * @param string $defenderName
     * @param string $skillName
     * @param int $reductionAmount
     */
    public function logDamageReduction(string $defenderName, string $skillName, int $reductionAmount): void;

    /**
     * @param string $playerName
     */
    public function logDeath(string $playerName): void;

    /**
     * @param string $winnerName
     */
    public function declareWinner(string $winnerName): void;

    /**
     * @param string $message
     */
    public function logMessage(string $message): void;
}
