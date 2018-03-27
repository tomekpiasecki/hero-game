<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Domain\Factories;

use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Policies\AttackerSelectionPolicy;
use Tpiasecki\HeroGame\Domain\Policies\AttackerSelectionPolicyInterface;

class AttackerSelectionPolicyFactory implements AttackerSelectionPolicyFactoryInterface
{
    /**
     * @var SpeedBasedPolicyFactory
     */
    private $speedBasedPolicyFactory;

    /**
     * @var LuckBasedPolicyFactory
     */
    private $luckBasedPolicyFactory;

    /**
     * @param SpeedBasedPolicyFactory $speedBasedPolicyFactory
     * @param LuckBasedPolicyFactory $luckBasedPolicyFactory
     */
    public function __construct(
        SpeedBasedPolicyFactory $speedBasedPolicyFactory,
        LuckBasedPolicyFactory $luckBasedPolicyFactory
    ) {
        $this->speedBasedPolicyFactory = $speedBasedPolicyFactory;
        $this->luckBasedPolicyFactory = $luckBasedPolicyFactory;
    }

    /**
     * @param CharacterInterface $player1
     * @param CharacterInterface $player2
     * @return AttackerSelectionPolicyInterface
     */
    public function createPolicy(
        CharacterInterface $player1,
        CharacterInterface $player2
    ): AttackerSelectionPolicyInterface {
        return new AttackerSelectionPolicy(
            $player1,
            $player2,
            $this->speedBasedPolicyFactory,
            $this->luckBasedPolicyFactory
        );
    }
}
