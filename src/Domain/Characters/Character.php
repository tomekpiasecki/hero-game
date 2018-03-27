<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Characters;

use Tpiasecki\HeroGame\Domain\Skills\SkillInterface;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

abstract class Character implements CharacterInterface
{
    /**
     * @var int
     */
    private $health;

    /**
     * @var int
     */
    private $strength;

    /**
     * @var int
     */
    private $defence;

    /**
     * @var int
     */
    private $speed;

    /**
     * @var int
     */
    private $luck;

    /**
     * @var string
     */
    private $name;

    /**
     * @var CharacterType
     */
    private $type;

    /**
     * @var array
     */
    private $skills;

    /**
     * @var RandomnessProviderInterface
     */
    private $randomnessProvider;

    /**
     * Character constructor.
     * @param int $health
     * @param int $strength
     * @param int $defence
     * @param int $speed
     * @param int $luck
     * @param string $name
     * @param CharacterType $type
     * @param RandomnessProviderInterface $randomnessProvider
     * @param SkillInterface[] $skills
     */
    public function __construct(
        int $health,
        int $strength,
        int $defence,
        int $speed,
        int $luck,
        string $name,
        CharacterType $type,
        RandomnessProviderInterface $randomnessProvider,
        array $skills = []
    ) {
        $this->health = $health;
        $this->strength = $strength;
        $this->defence = $defence;
        $this->speed = $speed;
        $this->luck = $luck;
        $this->name = $name;
        $this->type = $type;
        $this->skills = $skills;
        $this->randomnessProvider = $randomnessProvider;
    }

    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }

    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * @return int
     */
    public function getDefence(): int
    {
        return $this->defence;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }

    /**
     * @return int
     */
    public function getLuck(): int
    {
        return $this->luck;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return CharacterType
     */
    public function getType(): CharacterType
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getSkills(): array
    {
        return $this->skills;
    }

    /**
     * @param int $damage
     */
    public function applyDamage(int $damage): void
    {
        $this->health -= ($damage <= $this->health ? $damage : $this->health);
    }

    /**
     * @return bool
     */
    public function isAlive(): bool
    {
        return $this->health > 0;
    }

    /**
     * @return bool
     */
    public function isLucky(): bool
    {
        $luckyDraw = $this->randomnessProvider->randomInt(1, 100);
        return $luckyDraw <= $this->luck;
    }

    /**
     * @param CharacterInterface $character
     * @return bool
     */
    public function equals(CharacterInterface $character): bool
    {
        return $this->type->equals($character->getType()) && $this->name === $character->getName();
    }
}
