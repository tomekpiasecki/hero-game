<?php

declare(strict_types=1);

use Tpiasecki\HeroGame\Application\GameService;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @var \DI\Container $container
 */
$container = require_once __DIR__ . '/../src/bootstrap.php';


/**
 * @var GameService $game
 */
$game = $container->get(GameService::class);
$game->startGame();