<?php

declare(strict_types=1);

namespace Tpiasecki\HeroGame\Application;

use Tpiasecki\HeroGame\Domain\BattleInterface;
use Tpiasecki\HeroGame\Domain\Factories\BattleFactoryInterface;
use Tpiasecki\HeroGame\Domain\Factories\BeastFactory;
use Tpiasecki\HeroGame\Domain\Factories\HeroFactory;

class GameService
{
    /**
     * @var HeroFactory
     */
    private $heroFactory;

    /**
     * @var BeastFactory
     */
    private $beastFactory;

    /**
     * @var BattleFactoryInterface
     */
    private $battleFactory;

    /**
     * @var BattleInterface
     */
    private $battle;

    /**
     * @param HeroFactory $heroFactory
     * @param BeastFactory $beastFactory
     * @param BattleFactoryInterface $battleFactory
     */
    public function __construct(
        HeroFactory $heroFactory,
        BeastFactory $beastFactory,
        BattleFactoryInterface $battleFactory
    ) {
        $this->heroFactory = $heroFactory;
        $this->beastFactory = $beastFactory;
        $this->battleFactory = $battleFactory;

        $this->init();
    }

    private function init(): void
    {
        $hero = $this->heroFactory->createFromName('Orderus');
        $beast = $this->beastFactory->createFromName('Monster');

        $this->battle = $this->battleFactory->createBattle($hero, $beast);
    }

    public function startGame(): void
    {
        $this->battle->start();
    }
}
