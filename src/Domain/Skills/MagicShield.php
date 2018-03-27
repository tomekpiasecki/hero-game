<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Skills;

class MagicShield extends Skill
{
    /**
     * @var int
     */
    protected static $probability = 20;

    /**
     * @var string
     */
    protected static $name = 'Magic Shield';

    /**
     * @var int
     */
    protected static $reductionFactor = 2;


    public function reduceDamage(int $damage): int
    {
        if (!$this->shouldOccur()) {
            return $damage;
        }

        return (int) ($damage / self::$reductionFactor);
    }
}
