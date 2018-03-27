<?php

namespace Tpiasecki\HeroGame\Domain;

interface BattleInterface
{
    /**
     * Starts the battle
     */
    public function start(): void;

    /**
     * Performs single turn
     */
    public function doTurn(): void;
}
