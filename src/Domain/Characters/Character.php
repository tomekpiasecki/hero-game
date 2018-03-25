<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Characters;

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
     * Character constructor.
     * @param int $health
     * @param int $strength
     * @param int $defence
     * @param int $speed
     * @param int $luck
     * @param string $name
     * @param CharacterType $type
     * @param array $skills
     */
    public function __construct(
        int $health,
        int $strength,
        int $defence,
        int $speed,
        int $luck,
        string $name,
        CharacterType $type,
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
}
