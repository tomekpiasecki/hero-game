<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Skills;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Skills\MagicShield;

class MagicShieldTest extends TestCase
{
    public function testIsCreatedCorrectly()
    {
        $this->assertInstanceOf(MagicShield::class, new MagicShield());
    }
}
