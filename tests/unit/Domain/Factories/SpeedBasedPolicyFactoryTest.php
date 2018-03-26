<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Factories\SpeedBasedPolicyFactory;
use Tpiasecki\HeroGame\Domain\Policies\SpeedBasedSelectionPolicy;
use Tpiasecki\HeroGameTest\unit\Domain\Policies\PolicyTestHelper;

class SpeedBasedPolicyFactoryTest extends TestCase
{
    /**
     * @var SpeedBasedPolicyFactory
     */
    private $factory;

    /**
     * @var PolicyTestHelper
     */
    private $policyTestHelper;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new SpeedBasedPolicyFactory();
        $this->policyTestHelper = new PolicyTestHelper();
    }

    public function testCreatesPolicyCorrectly()
    {
        $player1Mock = $this->policyTestHelper->getPlayer(35);
        $player2Mock = $this->policyTestHelper->getPlayer(48);


        $policy = $this->factory->createPolicy($player1Mock, $player2Mock);

        $this->assertInstanceOf(SpeedBasedSelectionPolicy::class, $policy);
    }
}
