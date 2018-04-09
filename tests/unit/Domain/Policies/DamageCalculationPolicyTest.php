<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGameTest\unit\Domain\Policies;

use PHPUnit\Framework\TestCase;
use Tpiasecki\HeroGame\Domain\Characters\CharacterInterface;
use Tpiasecki\HeroGame\Domain\Policies\DamageCalculationPolicy;
use Tpiasecki\HeroGame\Domain\Skills\SkillInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;

class DamageCalculationPolicyTest extends TestCase
{
    /**
     * @var BattleLoggerInterface
     */
    private $loggerMock;

    protected function setUp()
    {
        $this->loggerMock = $this->prophesize(BattleLoggerInterface::class);
    }

    public function testCalculatesCorrectlyForMishit(): void
    {
        $attackerMock = $this->getAttackerMock(0);
        $defenderMock = $this->getDefenderMock(0, '', true);

        $policy = new DamageCalculationPolicy(
            $attackerMock->reveal(),
            $defenderMock->reveal(),
            $this->loggerMock->reveal()
        );

        $this->assertEquals(0, $policy->calculateDamage());
    }

    /**
     * @dataProvider getDamageTestData
     * @param $attackerStrength
     * @param $defenderDefence
     * @param int $result
     */
    public function testCalculatesCorrectlyForDefenderWithoutSkills($attackerStrength, $defenderDefence, $result)
    {
        $attackerMock = $this->getAttackerMock($attackerStrength);

        $defenderMock = $this->getDefenderMock($defenderDefence, '', false);
        $defenderMock->getSkills()->willReturn([]);

        $policy = new DamageCalculationPolicy(
            $attackerMock->reveal(),
            $defenderMock->reveal(),
            $this->loggerMock->reveal()
        );

        $this->assertEquals($result, $policy->calculateDamage());
    }

    public function getDamageTestData(): array
    {
        return [
            [90, 60, 30],
            [61, 60, 1],
            [45, 50, 0],
        ];
    }

    /**
     * @dataProvider getSingleSkillData
     * @param int $attackerStrength
     * @param int $defenderDefence
     * @param int $damageReducedBySkill
     * @param int $result
     */
    public function testAppliesSingleSkillCorrectly(
        int $attackerStrength,
        int $defenderDefence,
        int $damageReducedBySkill,
        int $result
    ): void {
        $attackerMock = $this->getAttackerMock($attackerStrength);

        $basicDamage = $attackerStrength - $defenderDefence;

        $skillMock = $this->getSkillMock('test skill', $basicDamage, $damageReducedBySkill, 1);
        $defenderMock = $this->getDefenderMock($defenderDefence, 'defender', false);
        $defenderMock->getSkills()->willReturn([$skillMock]);
        $defenderMock = $defenderMock->reveal();

        $this->loggerMock->logDamageReduction(
            $defenderMock->getName(),
            $skillMock->getName(),
            $damageReducedBySkill
        )->shouldBeCalledTimes(1);
        $policy = new DamageCalculationPolicy(
            $attackerMock->reveal(),
            $defenderMock,
            $this->loggerMock->reveal()
        );


        $this->assertEquals($result, $policy->calculateDamage());
    }

    public function getSingleSkillData(): array
    {
        return [
            [90, 60, 15, 15],
            [70, 50, 10, 10]
        ];
    }

    /**
     * @dataProvider getSingleSkillData
     * @param int $attackerStrength
     * @param int $defenderDefence
     * @param int $damageReducedBySkill
     * @param int $result
     */
    public function testCalculatesCorrectlyForTwoSkillsWhenOnlyOneApplicable(
        int $attackerStrength,
        int $defenderDefence,
        int $damageReducedBySkill,
        int $result
    ): void {
        $attackerMock = $this->getAttackerMock($attackerStrength);

        $basicDamage = $attackerStrength - $defenderDefence;
        $skill1Mock = $this->getSkillMock('test skill1', $basicDamage, $damageReducedBySkill, 1);

        $skill2Mock = $this->prophesize(SkillInterface::class);
        $skill2Mock->reduceDamage($damageReducedBySkill)->willReturn($damageReducedBySkill);
        $skill2Mock->getName()->willReturn('test skill 2');
        $skill2Mock = $skill2Mock->reveal();

        $defenderMock = $this->getDefenderMock($defenderDefence, 'defender', false);
        $defenderMock->getSkills()->willReturn([$skill1Mock, $skill2Mock]);
        $defenderMock = $defenderMock->reveal();

        $this->loggerMock->logDamageReduction(
            $defenderMock->getName(),
            $skill1Mock->getName(),
            $damageReducedBySkill
        )->shouldBeCalledTimes(1);
        $policy = new DamageCalculationPolicy(
            $attackerMock->reveal(),
            $defenderMock,
            $this->loggerMock->reveal()
        );

        $this->assertEquals($result, $policy->calculateDamage());
    }

    /**
     * @param int $strength
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    private function getAttackerMock(int $strength)
    {
        $mock = $this->prophesize(CharacterInterface::class);
        $mock->getStrength()->willReturn($strength);

        return $mock;
    }

    /**
     * @param int $defence
     * @param string $name
     * @param bool $isLucky
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    private function getDefenderMock(int $defence, string $name, bool $isLucky)
    {
        $mock = $this->prophesize(CharacterInterface::class);
        $mock->getDefence()->willReturn($defence);
        $mock->getName()->willReturn($name);
        $mock->isLucky()->willReturn($isLucky);

        return $mock;
    }

    /**
     * @param string $name
     * @param int $reducedDamageArgument
     * @param int $reduceDamageResult
     * @param int $timesReduceDamageShouldBeCalled
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    private function getSkillMock(
        string $name,
        int $reducedDamageArgument,
        int $reduceDamageResult,
        int $timesReduceDamageShouldBeCalled
    ) {
        $mock = $this->prophesize(SkillInterface::class);
        $mock->getName()->willReturn($name);
        $mock->reduceDamage($reducedDamageArgument)->willReturn($reduceDamageResult);
        $mock->reduceDamage($reducedDamageArgument)->shouldBeCalledTimes($timesReduceDamageShouldBeCalled);

        return $mock->reveal();
    }
}
