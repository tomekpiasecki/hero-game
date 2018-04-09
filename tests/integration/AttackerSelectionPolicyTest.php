<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\integration;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Factories\LuckBasedPolicyFactory;
use Tpiasecki\HeroGame\Domain\Factories\SpeedBasedPolicyFactory;
use Tpiasecki\HeroGame\Domain\Policies\AttackerSelectionPolicy;

class AttackerSelectionPolicyTest extends TestCase
{
    /**
     * @dataProvider getTestData
     * @param $player1Data
     * @param $player2Data
     * @param $attackerName
     * @param $defenderName
     */
    public function testSelectsCorrectly($player1Data, $player2Data, $attackerName, $defenderName): void
    {
        $player1Mock = $this->prophesize(CharacterInterface::class);
        $player1Mock->getSpeed()->willReturn($player1Data['strength']);
        $player1Mock->getLuck()->willReturn($player1Data['luck']);
        $player1Mock->getName()->willReturn($player1Data['name']);
        $player1Mock = $player1Mock->reveal();

        $player2Mock = $this->prophesize(CharacterInterface::class);
        $player2Mock->getSpeed()->willReturn($player2Data['strength']);
        $player2Mock->getLuck()->willReturn($player2Data['luck']);
        $player2Mock->getName()->willReturn($player2Data['name']);
        $player2Mock = $player2Mock->reveal();

        $speedPolicyFactory = new SpeedBasedPolicyFactory();
        $luckPolicyFactory = new LuckBasedPolicyFactory();

        $policy = new AttackerSelectionPolicy($player1Mock, $player2Mock, $speedPolicyFactory, $luckPolicyFactory);
        $this->assertEquals($attackerName, $policy->getAttacker()->getName());
        $this->assertEquals($defenderName, $policy->getDefender()->getName());
    }

    public function getTestData(): array
    {
        return[
            [
                [
                    'strength' => 50,
                    'luck' => 10,
                    'name' => 'player1'
                ],
                [
                    'strength' => 40,
                    'luck' => 30,
                    'name' => 'player2'
                ],
                'player1',
                'player2'
            ],
            [
                [
                    'strength' => 40,
                    'luck' => 10,
                    'name' => 'player1'
                ],
                [
                    'strength' => 45,
                    'luck' => 30,
                    'name' => 'player2'
                ],
                'player2',
                'player1'
            ],
            [
                [
                    'strength' => 40,
                    'luck' => 20,
                    'name' => 'player1'
                ],
                [
                    'strength' => 40,
                    'luck' => 10,
                    'name' => 'player2'
                ],
                'player1',
                'player2'
            ],
            [
                [
                    'strength' => 40,
                    'luck' => 15,
                    'name' => 'player1'
                ],
                [
                    'strength' => 40,
                    'luck' => 25,
                    'name' => 'player2'
                ],
                'player2',
                'player1'
            ],
            [
                [
                    'strength' => 40,
                    'luck' => 20,
                    'name' => 'player1'
                ],
                [
                    'strength' => 40,
                    'luck' => 20,
                    'name' => 'player2'
                ],
                'player2',
                'player1'
            ]
        ];
    }
}