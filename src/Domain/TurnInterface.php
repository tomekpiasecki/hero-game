<?php

namespace Tpiasecki\HeroGame\Domain;

interface TurnInterface
{
    /**
     * Performs single turn
     */
    public function doTurn(): void;
}
