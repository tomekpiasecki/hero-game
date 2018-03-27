<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\Beast;
use Tpiasecki\HeroGame\Domain\Characters\CharacterType;
use Tpiasecki\HeroGame\Domain\Factories\BeastFactory;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

class BeastFactoryTest extends TestCase
{
    /**
     * @var CharacterType
     */
    private $characterType;

    /**
     * @var BeastFactory
     */
    private $beastFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->characterType = new CharacterType(CharacterType::TYPE_BEAST);

        $randomnessProviderMock = $this->prophesize(RandomnessProviderInterface::class);
        $randomnessProviderMock->randomInt(Beast::HEALTH_MIN, Beast::HEALTH_MAX)->willReturn(Beast::HEALTH_MIN + 2);
        $randomnessProviderMock->randomInt(Beast::STRENGTH_MIN, Beast::STRENGTH_MAX)->willReturn(Beast::STRENGTH_MIN + 2);
        $randomnessProviderMock->randomInt(Beast::DEFENCE_MIN, Beast::DEFENCE_MAX)->willReturn(Beast::DEFENCE_MIN + 2);
        $randomnessProviderMock->randomInt(Beast::SPEED_MIN, Beast::SPEED_MAX)->willReturn(Beast::SPEED_MIN + 2);
        $randomnessProviderMock->randomInt(Beast::LUCK_MIN, Beast::LUCK_MAX)->willReturn(Beast::LUCK_MIN + 2);

        $this->beastFactory = new BeastFactory($randomnessProviderMock->reveal());
    }

    public function testCreatesValidBeast()
    {
        $name = 'Ugly beast';
        $beast = $this->beastFactory->createFromName($name);

        $this->assertInstanceOf(Beast::class, $beast);
        $this->assertEquals($name, $beast->getName());
        $this->assertGreaterThanOrEqual(Beast::HEALTH_MIN, $beast->getHealth());
        $this->assertLessThanOrEqual(Beast::HEALTH_MAX, $beast->getHealth());
        $this->assertGreaterThanOrEqual(Beast::STRENGTH_MIN, $beast->getStrength());
        $this->assertLessThanOrEqual(Beast::STRENGTH_MAX, $beast->getStrength());
        $this->assertGreaterThanOrEqual(Beast::DEFENCE_MIN, $beast->getDefence());
        $this->assertLessThanOrEqual(Beast::DEFENCE_MAX, $beast->getDefence());
        $this->assertGreaterThanOrEqual(Beast::SPEED_MIN, $beast->getSpeed());
        $this->assertLessThanOrEqual(Beast::SPEED_MAX, $beast->getSpeed());
        $this->assertGreaterThanOrEqual(Beast::LUCK_MIN, $beast->getLuck());
        $this->assertLessThanOrEqual(Beast::LUCK_MAX, $beast->getLuck());
        $this->assertTrue($beast->getType()->equals($this->characterType));
        $this->assertEmpty($beast->getSkills());
    }
}
