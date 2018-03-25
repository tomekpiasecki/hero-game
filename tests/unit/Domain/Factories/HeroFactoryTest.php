<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\Hero;
use Tpiasecki\HeroGame\Domain\Factories\HeroFactory;

class HeroFactoryTest extends TestCase
{
    /**
     * @var HeroFactory
     */
    private $heroFactory;

    protected function setUp()
    {
        $this->heroFactory = new HeroFactory();
    }

    public function testCreatesValidHero()
    {
        $name = 'Super hero';
        $hero = $this->heroFactory->createFromName($name);

        $this->assertInstanceOf(Hero::class, $hero);
        $this->assertEquals($name, $hero->getName());
        $this->assertGreaterThanOrEqual(Hero::HEALTH_MIN, $hero->getHealth());
        $this->assertLessThanOrEqual(Hero::HEALTH_MAX, $hero->getHealth());
        $this->assertGreaterThanOrEqual(Hero::STRENGTH_MIN, $hero->getStrength());
        $this->assertLessThanOrEqual(Hero::STRENGTH_MAX, $hero->getStrength());
        $this->assertGreaterThanOrEqual(Hero::DEFENCE_MIN, $hero->getDefence());
        $this->assertLessThanOrEqual(Hero::DEFENCE_MAX, $hero->getDefence());
        $this->assertGreaterThanOrEqual(Hero::SPEED_MIN, $hero->getSpeed());
        $this->assertLessThanOrEqual(Hero::SPEED_MAX, $hero->getSpeed());
        $this->assertGreaterThanOrEqual(Hero::LUCK_MIN, $hero->getLuck());
        $this->assertLessThanOrEqual(Hero::LUCK_MAX, $hero->getLuck());
    }
}
