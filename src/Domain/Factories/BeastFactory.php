<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\Beast;
use Tpiasecki\HeroGame\Domain\Characters\CharacterType;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

class BeastFactory
{
    /**
     * @var RandomnessProviderInterface
     */
    protected $randomnessProvider;

    /**
     * @param RandomnessProviderInterface $randomnessProvider
     */
    public function __construct(RandomnessProviderInterface $randomnessProvider)
    {
        $this->randomnessProvider = $randomnessProvider;
    }

    public function createFromName(string $name): Beast
    {
        $type = new CharacterType(CharacterType::TYPE_BEAST);
        return new Beast(
            $this->randomnessProvider->randomInt(Beast::HEALTH_MIN, Beast::HEALTH_MAX),
            $this->randomnessProvider->randomInt(Beast::STRENGTH_MIN, Beast::STRENGTH_MAX),
            $this->randomnessProvider->randomInt(Beast::DEFENCE_MIN, Beast::DEFENCE_MAX),
            $this->randomnessProvider->randomInt(Beast::SPEED_MIN, Beast::SPEED_MAX),
            $this->randomnessProvider->randomInt(Beast::LUCK_MIN, Beast::LUCK_MAX),
            $name,
            $type,
            $this->randomnessProvider
        );
    }
}
