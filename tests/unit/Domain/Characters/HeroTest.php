<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Characters;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Tpiasecki\HeroGame\Domain\Characters\CharacterType;
use Tpiasecki\HeroGame\Domain\Characters\Hero;
use Tpiasecki\HeroGame\Domain\Skills\SkillInterface;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

class HeroTest extends TestCase
{
    /**
     * @var array
     */
    private $props;

    /**
     * @var CharacterType
     */
    private $type;

    /**
     * @var RandomnessProviderInterface
     */
    private $randomnessProvider;

    protected function setUp()
    {
        parent::setUp();
        $this->props = [
            'health' => 80,
            'strength' => 79,
            'defence' => 50,
            'speed' => 47,
            'luck' => 20,
            'name' => 'TestName'
        ];
        $this->props['skills'][] = $this->prophesize(SkillInterface::class)->reveal();
        $this->props['skills'][] = $this->prophesize(SkillInterface::class)->reveal();

        $this->type = $this->prophesize(CharacterType::class)->reveal();
        $this->randomnessProvider = $this->prophesize(RandomnessProviderInterface::class);
    }

    public function testShouldCreateCorrectObject(): void
    {
        $hero = new Hero(
            $this->props['health'],
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $this->props['luck'],
            $this->props['name'],
            $this->type,
            $this->randomnessProvider->reveal(),
            $this->props['skills']
        );

        $this->assertSame($this->props['health'], $hero->getHealth());
        $this->assertSame($this->props['strength'], $hero->getStrength());
        $this->assertSame($this->props['defence'], $hero->getDefence());
        $this->assertSame($this->props['speed'], $hero->getSpeed());
        $this->assertSame($this->props['luck'], $hero->getLuck());
        $this->assertSame($this->props['name'], $hero->getName());
        $this->assertSame($this->type, $hero->getType());
        $this->assertSame($this->props['skills'], $hero->getSkills());
    }

    /**
     * @dataProvider getDamageTestData
     * @param int $initialHealth
     * @param int $damage
     * @param array $expected
     */
    public function testApplyingDamage(int $initialHealth, int $damage, array $expected):void
    {
        $hero = new Hero(
            $initialHealth,
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $this->props['luck'],
            $this->props['name'],
            $this->type,
            $this->randomnessProvider->reveal(),
            $this->props['skills']
        );

        $this->assertSame($initialHealth, $hero->getHealth());
        $this->assertTrue($hero->isAlive());
        $hero->applyDamage($damage);
        $this->assertSame($expected['health'], $hero->getHealth());
        $this->assertSame($expected['aliveStatus'], $hero->isAlive());
    }

    public function getDamageTestData(): array
    {
        return [
            [
                70,
                25,
                [
                    'health' => 45,
                    'aliveStatus' => true
                ]
            ],
            [
                85,
                84,
                [
                    'health' => 1,
                    'aliveStatus' => true
                ]
            ],
            [
                93,
                93,
                [
                    'health' => 0,
                    'aliveStatus' => false
                ]
            ],
            [
                99,
                100,
                [
                    'health' => 0,
                    'aliveStatus' => false
                ]
            ],
        ];
    }

    /**
     * @dataProvider getLuckTestData
     * @param int $luck
     * @param int $luckyDraw
     * @param bool $expected
     */
    public function testIsLucky(int $luck, int $luckyDraw, bool $expected): void
    {
        $this->randomnessProvider->randomInt(Argument::any(), Argument::any())->willReturn($luckyDraw);

        $hero = new Hero(
            $this->props['health'],
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $luck,
            $this->props['name'],
            $this->type,
            $this->randomnessProvider->reveal(),
            $this->props['skills']
        );

        $this->assertSame($expected, $hero->isLucky());
    }

    public function getLuckTestData(): array
    {
        return [
            [25, 15, true],
            [30, 1, true],
            [23, 22, true],
            [18, 18, true],
            [15, 16, false],
            [21, 100, false]
        ];
    }

    /**
     * @dataProvider getEqualsTestData
     * @param array $hero1Data
     * @param array $hero2Data
     * @param bool $expected
     */
    public function testEquals(array $hero1Data, array $hero2Data, bool $expected): void
    {

        $hero1 = new Hero(
            $this->props['health'],
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $this->props['luck'],
            $hero1Data['name'],
            $hero1Data['type'],
            $this->randomnessProvider->reveal(),
            $this->props['skills']
        );

        $hero2 = new Hero(
            $this->props['health'],
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $this->props['luck'],
            $hero2Data['name'],
            $hero2Data['type'],
            $this->randomnessProvider->reveal(),
            $this->props['skills']
        );

        $this->assertSame($expected, $hero1->equals($hero2));
    }

    public function getEqualsTestData(): array
    {
        return [
            'equals' => [
                [
                    'name' => 'name1',
                    'type' => $this->getType(true)
                ],
                [
                    'name' => 'name1',
                    'type' => $this->getType(true)
                ],
                true
            ],
            'different_name' => [
                [
                    'name' => 'name1',
                    'type' => $this->getType(true)
                ],
                [
                    'name' => 'name2',
                    'type' => $this->getType(true)
                ],
                false
            ],
            'different_type' => [
                [
                    'name' => 'name2',
                    'type' => $this->getType(false)
                ],
                [
                    'name' => 'name2',
                    'type' => $this->getType(false)
                ],
                false
            ]

        ];
    }

    private function getType(bool $isEqual): CharacterType
    {
        $type = $this->prophesize(CharacterType::class);
        $type->equals(Argument::any())->willReturn($isEqual);

        return $type->reveal();
    }
}
