<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Skills;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Skills\RapidStrike;

class RapidStrikeTest extends TestCase
{
    public function testIsCreatedCorrectly()
    {
        $this->assertInstanceOf(RapidStrike::class, new RapidStrike());
    }
}
