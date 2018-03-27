<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterType;
use Tpiasecki\HeroGame\Domain\Characters\Hero;
use Tpiasecki\HeroGame\Domain\Skills\MagicShield;
use Tpiasecki\HeroGame\Domain\Skills\RapidStrike;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

class HeroFactory
{
    /**
     * @var MagicShield
     */
    private $magicShield;

    /**
     * @var RapidStrike
     */
    private $rapidStrike;

    /**
     * @var RandomnessProviderInterface
     */
    protected $randomnessProvider;

    /**
     * @param MagicShield $magicShield
     * @param RapidStrike $rapidStrike
     * @param RandomnessProviderInterface $randomnessProvider
     */
    public function __construct(
        MagicShield $magicShield,
        RapidStrike $rapidStrike,
        RandomnessProviderInterface $randomnessProvider
    ) {
        $this->magicShield = $magicShield;
        $this->rapidStrike = $rapidStrike;
        $this->randomnessProvider = $randomnessProvider;
    }

    public function createFromName(string $name): Hero
    {
        $type = new CharacterType(CharacterType::TYPE_HERO);
        $skills = [
            $this->magicShield,
            $this->rapidStrike
        ];

        return new Hero(
            $this->randomnessProvider->randomInt(Hero::HEALTH_MIN, Hero::HEALTH_MAX),
            $this->randomnessProvider->randomInt(Hero::STRENGTH_MIN, Hero::STRENGTH_MAX),
            $this->randomnessProvider->randomInt(Hero::DEFENCE_MIN, Hero::DEFENCE_MAX),
            $this->randomnessProvider->randomInt(Hero::SPEED_MIN, Hero::SPEED_MAX),
            $this->randomnessProvider->randomInt(Hero::LUCK_MIN, Hero::LUCK_MAX),
            $name,
            $type,
            $this->randomnessProvider,
            $skills
        );
    }
}
