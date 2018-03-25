<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Characters;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\CharacterType;

class CharacterTypeTest extends TestCase
{
    /**
     * @dataProvider getCorrectCharacterTypes
     * @param string $characterType
     */
    public function testReturnsCorrectType(string $characterType)
    {
        $type = new CharacterType($characterType);
        $this->assertEquals($characterType, $type->getType());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionOnInvalidType()
    {
        $type = new CharacterType('foo');
    }

    /**
     * @return array
     */
    public function getCorrectCharacterTypes(): array
    {
        return [
            [CharacterType::TYPE_HERO],
            [CharacterType::TYPE_BEAST]
        ];
    }

    /**
     * @dataProvider getDataForEqualTest
     */
    public function testEqualsReturnsCorrectValue(CharacterType $type1, CharacterType $type2, bool $expected)
    {
        $this->assertSame($expected, $type1->equals($type2));
    }

    public function getDataForEqualTest(): array
    {
        return [
            'equal_hero' => [
                new CharacterType(CharacterType::TYPE_BEAST),
                new CharacterType(CharacterType::TYPE_BEAST),
                true
            ],
            'equal_beast' => [
                new CharacterType(CharacterType::TYPE_BEAST),
                new CharacterType(CharacterType::TYPE_BEAST),
                true
            ],
            'not_equal' => [
                new CharacterType(CharacterType::TYPE_BEAST),
                new CharacterType(CharacterType::TYPE_HERO),
                false
            ],
        ];
    }
}
