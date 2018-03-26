<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Policies;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Policies\LuckBasedSelectionPolicy;

class LuckBasedSelectionPolicyTest extends TestCase
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
    public function testThrowsExceptionForEqualLuck()
    {
        $luck = 20;

        $policy = new LuckBasedSelectionPolicy(
            $this->policyTestHelper->getPlayer($luck),
            $this->policyTestHelper->getPlayer($luck)
        );
    }

    public function testSelectsCorrectly()
    {
        $player1Mock = $this->policyTestHelper->getPlayer(10, 15);
        $player2Mock = $this->policyTestHelper->getPlayer(10, 25);

        $policy = new LuckBasedSelectionPolicy($player1Mock, $player2Mock);

        $this->assertSame($player2Mock, $policy->getAttacker());
        $this->assertSame($player1Mock, $policy->getDefender());
    }
}
