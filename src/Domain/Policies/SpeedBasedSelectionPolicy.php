<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Policies;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;

class SpeedBasedSelectionPolicy implements AttackerSelectionPolicyInterface
{
    /**
     * @var CharacterInterface
     */
    private $player1;

    /**
     * @var CharacterInterface
     */
    private $player2;

    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @throws NotAbleToSelectAttackerException
     */
    public function __construct(CharacterInterface $player1, CharacterInterface $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;

        if ($this->player1->getSpeed() === $this->player2->getSpeed()) {
            throw new NotAbleToSelectAttackerException();
        }
    }

    public function getAttacker(): CharacterInterface
    {
        return $this->player1->getSpeed() > $this->player2->getSpeed() ? $this->player1 : $this->player2;
    }

    public function getDefender(): CharacterInterface
    {
        return $this->player1->getSpeed() < $this->player2->getSpeed() ? $this->player1 : $this->player2;
    }
}
