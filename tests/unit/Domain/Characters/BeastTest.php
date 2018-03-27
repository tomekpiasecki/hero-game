<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Characters;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Tpiasecki\HeroGame\Domain\Characters\Beast;
use Tpiasecki\HeroGame\Domain\Characters\CharacterType;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

class BeastTest extends TestCase
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
            'health' => 66,
            'strength' => 75,
            'defence' => 43,
            'speed' => 51,
            'luck' => 33,
            'name' => 'TestName'
        ];

        $this->type = $this->prophesize(CharacterType::class)->reveal();
        $this->randomnessProvider = $this->prophesize(RandomnessProviderInterface::class);
    }

    public function testShouldCreateCorrectObject(): void
    {
        $beast = new Beast(
            $this->props['health'],
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $this->props['luck'],
            $this->props['name'],
            $this->type,
            $this->randomnessProvider->reveal(),
            []
        );

        $this->assertSame($this->props['health'], $beast->getHealth());
        $this->assertSame($this->props['strength'], $beast->getStrength());
        $this->assertSame($this->props['defence'], $beast->getDefence());
        $this->assertSame($this->props['speed'], $beast->getSpeed());
        $this->assertSame($this->props['luck'], $beast->getLuck());
        $this->assertSame($this->props['name'], $beast->getName());
        $this->assertSame($this->type, $beast->getType());
        $this->assertSame([], $beast->getSkills());
    }

    /**
     * @dataProvider getDamageTestData
     * @param int $initialHealth
     * @param int $damage
     * @param array $expected
     */
    public function testApplyingDamage(int $initialHealth, int $damage, array $expected):void
    {
        $beast = new Beast(
            $initialHealth,
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $this->props['luck'],
            $this->props['name'],
            $this->type,
            $this->randomnessProvider->reveal(),
            []
        );

        $this->assertSame($initialHealth, $beast->getHealth());
        $this->assertTrue($beast->isAlive());
        $beast->applyDamage($damage);
        $this->assertSame($expected['health'], $beast->getHealth());
        $this->assertSame($expected['aliveStatus'], $beast->isAlive());
    }

    public function getDamageTestData(): array
    {
        return [
            [
                60,
                20,
                [
                    'health' => 40,
                    'aliveStatus' => true
                ]
            ],
            [
                75,
                74,
                [
                    'health' => 1,
                    'aliveStatus' => true
                ]
            ],
            [
                83,
                83,
                [
                    'health' => 0,
                    'aliveStatus' => false
                ]
            ],
            [
                91,
                98,
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

        $beast = new Beast(
            $this->props['health'],
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $luck,
            $this->props['name'],
            $this->type,
            $this->randomnessProvider->reveal(),
            []
        );

        $this->assertSame($expected, $beast->isLucky());
    }

    public function getLuckTestData(): array
    {
        return [
            [25, 15, true],
            [30, 1, true],
            [33, 32, true],
            [38, 38, true],
            [15, 16, false],
            [21, 100, false]
        ];
    }

    /**
     * @dataProvider getEqualsTestData
     * @param array $beast1Data
     * @param array $beast2Data
     * @param bool $expected
     */
    public function testEquals(array $beast1Data, array $beast2Data, bool $expected): void
    {

        $beast1 = new Beast(
            $this->props['health'],
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $this->props['luck'],
            $beast1Data['name'],
            $beast1Data['type'],
            $this->randomnessProvider->reveal(),
            []
        );

        $beast2 = new Beast(
            $this->props['health'],
            $this->props['strength'],
            $this->props['defence'],
            $this->props['speed'],
            $this->props['luck'],
            $beast2Data['name'],
            $beast2Data['type'],
            $this->randomnessProvider->reveal(),
            []
        );

        $this->assertSame($expected, $beast1->equals($beast2));
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
