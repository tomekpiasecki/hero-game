<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Factories;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Factories\LuckBasedPolicyFactory;
use Tpiasecki\HeroGame\Domain\Policies\LuckBasedSelectionPolicy;
use Tpiasecki\HeroGameTest\unit\Domain\Policies\PolicyTestHelper;

class LuckBasedPolicyFactoryTest extends TestCase
{
    /**
     * @var LuckBasedPolicyFactory
     */
    private $factory;

    /**
     * @var PolicyTestHelper
     */
    private $policyTestHelper;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new LuckBasedPolicyFactory();
        $this->policyTestHelper = new PolicyTestHelper();
    }

    public function testCreatesPolicyCorrectly()
    {
        $player1Mock = $this->policyTestHelper->getPlayer(55, 10);
        $player2Mock = $this->policyTestHelper->getPlayer(40, 40);


        $policy = $this->factory->createPolicy($player1Mock, $player2Mock);

        $this->assertInstanceOf(LuckBasedSelectionPolicy::class, $policy);
    }
}
