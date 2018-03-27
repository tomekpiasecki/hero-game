<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\CharacterType;
use Tpiasecki\HeroGame\Domain\Characters\Hero;
use Tpiasecki\HeroGame\Domain\Factories\HeroFactory;
use Tpiasecki\HeroGame\Domain\Skills\MagicShield;
use Tpiasecki\HeroGame\Domain\Skills\RapidStrike;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

class HeroFactoryTest extends TestCase
{
    /**
     * @var CharacterType
     */
    private $characterType;

    /**
     * @var array
     */
    private $skills;

    /**
     * @var HeroFactory
     */
    private $heroFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->characterType = new CharacterType(CharacterType::TYPE_HERO);

        $randomnessProviderMock = $this->prophesize(RandomnessProviderInterface::class);
        $randomnessProviderMock->randomInt(Hero::HEALTH_MIN, Hero::HEALTH_MAX)->willReturn(Hero::HEALTH_MIN + 2);
        $randomnessProviderMock->randomInt(Hero::STRENGTH_MIN, Hero::STRENGTH_MAX)->willReturn(Hero::STRENGTH_MIN + 2);
        $randomnessProviderMock->randomInt(Hero::DEFENCE_MIN, Hero::DEFENCE_MAX)->willReturn(Hero::DEFENCE_MIN + 2);
        $randomnessProviderMock->randomInt(Hero::SPEED_MIN, Hero::SPEED_MAX)->willReturn(Hero::SPEED_MIN + 2);
        $randomnessProviderMock->randomInt(Hero::LUCK_MIN, Hero::LUCK_MAX)->willReturn(Hero::LUCK_MIN + 2);

        $magicShieldMock = $this->prophesize(MagicShield::class)->reveal();
        $rapidStrikeMock = $this->prophesize(RapidStrike::class)->reveal();
        $this->skills = [$magicShieldMock, $rapidStrikeMock];

        $this->heroFactory = new HeroFactory($magicShieldMock, $rapidStrikeMock, $randomnessProviderMock->reveal());
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
        $this->assertTrue($hero->getType()->equals($this->characterType));
        $this->assertSame($this->skills, $hero->getSkills());
    }
}
