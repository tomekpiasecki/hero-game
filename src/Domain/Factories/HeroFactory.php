<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterType;
use Tpiasecki\HeroGame\Domain\Characters\Hero;

class HeroFactory
{
    public function createFromName(string $name): Hero
    {
        $type = new CharacterType(CharacterType::TYPE_HERO);
        return new Hero(
            random_int(Hero::HEALTH_MIN, Hero::HEALTH_MAX),
            random_int(Hero::STRENGTH_MIN, Hero::STRENGTH_MAX),
            random_int(Hero::DEFENCE_MIN, Hero::DEFENCE_MAX),
            random_int(Hero::SPEED_MIN, Hero::SPEED_MAX),
            random_int(Hero::LUCK_MIN, Hero::LUCK_MAX),
            $name,
            $type
        );
    }
}
