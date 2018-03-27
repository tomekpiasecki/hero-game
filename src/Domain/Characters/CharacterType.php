<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Characters;

class CharacterType
{
    const TYPE_HERO = 'hero';
    const TYPE_BEAST = 'beast';

    /**
     * @var array
     */
    private $allowedTypes = [
        self::TYPE_BEAST,
        self::TYPE_HERO
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->validateType($type);
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param CharacterType $obj
     * @return bool
     */
    public function equals(CharacterType $obj): bool
    {
        return $obj->getType() === $this->type;
    }

    /**
     * @param string $type
     */
    private function validateType(string $type): void
    {
        if (!in_array($type, $this->allowedTypes)) {
            throw new \InvalidArgumentException("$type is not valid character type");
        }
    }
}
