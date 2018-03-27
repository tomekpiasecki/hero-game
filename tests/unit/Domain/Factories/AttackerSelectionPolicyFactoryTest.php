<?php

//declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\AttackerSelectionPolicyFactory;
use Tpiasecki\HeroGame\Domain\Factories\LuckBasedPolicyFactory;
use Tpiasecki\HeroGame\Domain\Factories\SpeedBasedPolicyFactory;
use Tpiasecki\HeroGame\Domain\Policies\AttackerSelectionPolicyInterface;
use Tpiasecki\HeroGame\Domain\Policies\LuckBasedSelectionPolicy;
use Tpiasecki\HeroGame\Domain\Policies\SpeedBasedSelectionPolicy;

class AttackerSelectionPolicyFactoryTest extends TestCase
{
    public function testCreatesPolicy(): void
    {
        $player1Mock = $this->prophesize(CharacterInterface::class)->reveal();
        $player2Mock = $this->prophesize(CharacterInterface::class)->reveal();

        $speedBasedPolicy = $this->prophesize(SpeedBasedSelectionPolicy::class);
        $speedBasedPolicy->getAttacker()->willReturn($player1Mock);
        $speedBasedPolicy->getDefender()->willReturn($player2Mock);
        $speedBasedPolicy = $speedBasedPolicy->reveal();
        $speedBasedPolicyFactoryMock = $this->prophesize(SpeedBasedPolicyFactory::class);
        $speedBasedPolicyFactoryMock->createPolicy(Argument::any(), Argument::any())->willReturn($speedBasedPolicy);
        $speedBasedPolicyFactoryMock = $speedBasedPolicyFactoryMock->reveal();

        $luckBasedPolicy = $this->prophesize(LuckBasedSelectionPolicy::class);
        $luckBasedPolicy->getAttacker()->willReturn($player1Mock);
        $luckBasedPolicy->getDefender()->willReturn($player2Mock);
        $luckBasedPolicy = $luckBasedPolicy->reveal();
        $luckBasedPolicyFactoryMock = $this->prophesize(LuckBasedPolicyFactory::class);
        $luckBasedPolicyFactoryMock->createPolicy(Argument::any(), Argument::any())->willReturn($luckBasedPolicy);
        $luckBasedPolicyFactoryMock = $luckBasedPolicyFactoryMock->reveal();

        $factory = new AttackerSelectionPolicyFactory($speedBasedPolicyFactoryMock, $luckBasedPolicyFactoryMock);
        $policy = $factory->createPolicy($player1Mock, $player2Mock);

        $this->assertInstanceOf(AttackerSelectionPolicyInterface::class, $policy);
    }
}
