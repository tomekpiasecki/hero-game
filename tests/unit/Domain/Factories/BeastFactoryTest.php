<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\Beast;
use Tpiasecki\HeroGame\Domain\Characters\CharacterType;
use Tpiasecki\HeroGame\Domain\Factories\BeastFactory;

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
        $this->beastFactory = new BeastFactory();
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
