<?php

namespace Tpiasecki\HeroGame\Domain\Characters;

use Tpiasecki\HeroGame\Domain\Skills\SkillInterface;

interface CharacterInterface
{
    /**
     * @return int
     */
    public function getHealth(): int;

    /**
     * @return int
     */
    public function getStrength(): int;

    /**
     * @return int
     */
    public function getDefence(): int;

    /**
     * @return int
     */
    public function getSpeed(): int;

    /**
     * @return int
     */
    public function getLuck(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return CharacterType
     */
    public function getType(): CharacterType;

    /**
     * @return SkillInterface[]
     */
    public function getSkills(): array;

    /**
     * @param int $damage
     */
    public function applyDamage(int $damage): void;

    /**
     * @return bool
     */
    public function isAlive(): bool;

    /**
     * @return bool
     */
    public function isLucky(): bool;

    /**
     * @param CharacterInterface $character
     * @return bool
     */
    public function equals(CharacterInterface $character): bool;
}
