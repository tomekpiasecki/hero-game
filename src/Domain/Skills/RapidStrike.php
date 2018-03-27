<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Skills;

class RapidStrike extends Skill
{
    protected static $probability = 10;

    /**
     * @return bool
     * @throws \Exception
     */
    public function shouldAttackAgain(): bool
    {
        return $this->shouldOccur();
    }
}
