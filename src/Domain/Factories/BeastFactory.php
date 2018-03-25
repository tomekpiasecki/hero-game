<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\Beast;
use Tpiasecki\HeroGame\Domain\Characters\CharacterType;

class BeastFactory
{
    public function createFromName(string $name): Beast
    {
        $type = new CharacterType(CharacterType::TYPE_BEAST);
        return new Beast(
            random_int(Beast::HEALTH_MIN, Beast::HEALTH_MAX),
            random_int(Beast::STRENGTH_MIN, Beast::STRENGTH_MAX),
            random_int(Beast::DEFENCE_MIN, Beast::DEFENCE_MAX),
            random_int(Beast::SPEED_MIN, Beast::SPEED_MAX),
            random_int(Beast::LUCK_MIN, Beast::LUCK_MAX),
            $name,
            $type
        );
    }
}
