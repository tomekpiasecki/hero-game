<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Infrastructure;

class ConsoleLogger implements BattleLoggerInterface
{
    /**
     * @param string $player1Name
     * @param string $player2Name
     */
    public function logBattleStart(string $player1Name, string $player2Name): void
    {
        $this->logMessage("!!!!~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~!!!!");
        $this->logMessage("");
        $this->logMessage("Battle between $player1Name and $player2Name starts");
    }

    /**
     * @param int $turnNumber
     */
    public function logTurnStart(int $turnNumber): void
    {
        $this->logMessage("");
        $this->logMessage("    --------------------------------    ");
        $this->logMessage("");
        $this->logMessage("Turn {$turnNumber} starts");
    }

    /**
     * @param int $turnNumber
     */
    public function logTurnEnd(int $turnNumber): void
    {
        $this->logMessage("Turn {$turnNumber} is over");
    }

    /**
     * @param string $attackerName
     */
    public function logAttack(string $attackerName): void
    {
        $this->logMessage("$attackerName attacks");
    }

    /**
     * Logs missed strike
     */
    public function logMiss(): void
    {
        $this->logMessage("Oh no. It's a miss!!!");
    }

    /**
     * @param string $defenderName
     * @param int $damage
     * @param int $remainingHealth
     */
    public function logHit(string $defenderName, int $damage, int $remainingHealth): void
    {
        $this->logMessage("$defenderName looses $damage of health $remainingHealth remains");
    }

    /**
     * @param string $attackerName
     */
    public function logDoubleStrike(string $attackerName): void
    {
        $this->logMessage("$attackerName strikes again");
    }

    /**
     * @param string $defenderName
     * @param string $skillName
     * @param int $reductionAmount
     */
    public function logDamageReduction(string $defenderName, string $skillName, int $reductionAmount): void
    {
        $this->logMessage("$defenderName uses $skillName and reduces the damage by $reductionAmount");
    }

    /**
     * @param string $playerName
     */
    public function logDeath(string $playerName): void
    {
        $this->logMessage("");
        $this->logMessage("\u{1F480} \u{1F480} \u{1F480} $playerName is dead \u{1F480} \u{1F480} \u{1F480}");
        $this->logMessage("");
    }

    /**
     * @param string $winnerName
     */
    public function declareWinner(string $winnerName): void
    {
        $this->logMessage("");
        $this->logMessage("\u{1F389} \u{1F389} \u{1F389}  $winnerName is the winner \u{1F389} \u{1F389} \u{1F389}");
        $this->logMessage("");
    }

    /**
     * @param string $message
     */
    public function logMessage(string $message): void
    {
        print("    $message" . PHP_EOL);
        usleep(800000);
    }
}
