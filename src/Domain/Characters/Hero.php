<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Characters;

class Hero extends Character
{
    const HEALTH_MIN = 70;
    const HEALTH_MAX = 100;
    const STRENGTH_MIN = 70;
    const STRENGTH_MAX = 80;
    const DEFENCE_MIN = 45;
    const DEFENCE_MAX = 55;
    const SPEED_MIN = 40;
    const SPEED_MAX = 50;
    const LUCK_MIN = 10;
    const LUCK_MAX = 30;
}
