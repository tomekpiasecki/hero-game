<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Skills;

use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

abstract class Skill implements SkillInterface
{
    /**
     * @var int probability of occurrence
     */
    protected static $probability = 0;

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

    /**
     * @param int $damage
     * @return int
     */
    public function reduceDamage(int $damage): int
    {
        return $damage;
    }

    /**
     * @return bool
     */
    public function shouldAttackAgain(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    protected function shouldOccur(): bool
    {
        $luckyDraw = $this->randomnessProvider->randomInt(1, 100);
        return $luckyDraw <= static::$probability;
    }
}
