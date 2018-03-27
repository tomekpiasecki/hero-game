<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Skills;

class RapidStrike extends Skill
{
    /**
     * @var int
     */
    protected static $probability = 10;

    /**
     * @var string
     */
    protected static $name = 'Rapid Strike';

    /**
     * @return bool
     * @throws \Exception
     */
    public function shouldAttackAgain(): bool
    {
        return $this->shouldOccur();
    }
}
