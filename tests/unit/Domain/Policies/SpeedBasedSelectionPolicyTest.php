<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Policies;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Policies\SpeedBasedSelectionPolicy;

class SpeedBasedSelectionPolicyTest extends TestCase
{
    /**
     * @var PolicyTestHelper
     */
    private $policyTestHelper;

    protected function setUp()
    {
        parent::setUp();
        $this->policyTestHelper = new PolicyTestHelper();
    }

    /**
     * @expectedException \Tpiasecki\HeroGame\Domain\Policies\NotAbleToSelectAttackerException
     */
    public function testThrowsExceptionForEqualSpeed()
    {
        $speed = 50;

        $policy = new SpeedBasedSelectionPolicy(
            $this->policyTestHelper->getPlayer($speed),
            $this->policyTestHelper->getPlayer($speed)
        );
    }

    public function testSelectsCorrectly()
    {
        $player1Mock = $this->policyTestHelper->getPlayer(55, 10);
        $player2Mock = $this->policyTestHelper->getPlayer(40, 40);

        $policy = new SpeedBasedSelectionPolicy($player1Mock, $player2Mock);

        $this->assertSame($player1Mock, $policy->getAttacker());
        $this->assertSame($player2Mock, $policy->getDefender());
    }
}
