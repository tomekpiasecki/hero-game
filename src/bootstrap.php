<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Tpiasecki\HeroGame\Domain\Factories\AttackerSelectionPolicyFactory;
use Tpiasecki\HeroGame\Domain\Factories\AttackerSelectionPolicyFactoryInterface;
use Tpiasecki\HeroGame\Domain\Factories\BattleFactory;
use Tpiasecki\HeroGame\Domain\Factories\BattleFactoryInterface;
use Tpiasecki\HeroGame\Domain\Factories\DamageCalculationPolicyFactory;
use Tpiasecki\HeroGame\Domain\Factories\DamageCalculationPolicyFactoryInterface;
use Tpiasecki\HeroGame\Domain\Factories\TurnFactory;
use Tpiasecki\HeroGame\Domain\Factories\TurnFactoryInterface;
use Tpiasecki\HeroGame\Infrastructure\BattleLoggerInterface;
use Tpiasecki\HeroGame\Infrastructure\ConsoleLogger;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProvider;
use Tpiasecki\HeroGame\Infrastructure\RandomnessProviderInterface;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(
    [
        TurnFactoryInterface::class => \DI\autowire(TurnFactory::class),
        BattleFactoryInterface::class => \DI\autowire(BattleFactory::class),
        AttackerSelectionPolicyFactoryInterface::class => \DI\autowire(AttackerSelectionPolicyFactory::class),
        DamageCalculationPolicyFactoryInterface::class => \DI\autowire(DamageCalculationPolicyFactory::class),
        RandomnessProviderInterface::class => \DI\autowire(RandomnessProvider::class),
        BattleLoggerInterface::class => \DI\autowire(ConsoleLogger::class)
    ]
);

$container = $containerBuilder->build();

return $container;
