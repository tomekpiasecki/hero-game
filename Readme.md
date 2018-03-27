# Hero Game

Simple application implementing hero game

####Story
Once upon a time there was a great hero with some strengths and weaknesses.

Hero has the following stats:
  * Health: 70 - 100
  * Strength: 70 - 80
  * Defence: 45 – 55
  * Speed: 40 – 50
  * Luck: 10% - 30% (0% means no luck, 100% lucky all the time).
  
Also, he possesses 2 skills:
  * Rapid strike: Strike twice while it’s his turn to attack; there’s a 10% chance he’ll use this skill every time he attacks
  * Magic shield: Takes only half of the usual damage when an enemy attacks; there’s a 20% change he’ll use this skill every time he defends.

####Gameplay
As the hero walks the ever-green lands, he encounters some wild beasts, with the following properties:
  * Health: 60 - 90
  * Strength: 60 - 90
  * Defence: 40 – 60
  * Speed: 40 – 60
  * Luck: 25% - 40%

Application simulates a battle between hero and a beast. On every battle, hero and the beast must be initialized with random properties, within their ranges.

The first attack is done by the player with the higher speed. If both players have the same speed, than the attack is carried on by the player with the highest luck.

After an attack, the players switch roles: the attacker now defends and the defender now attacks.

The damage done by the attacker is calculated with the following formula:

 **Damage = Attacker strength – Defender defence**
 
The damage is subtracted from the defender’s health. An attacker can miss their hit and do no damage if the defender gets lucky that turn.

Hero's skills occur randomly, based on their chances, so take them into account on each turn.

####Game over
The game ends when one of the players remain without health or the number of turns reaches 20.

The application must output the results each turn: what happened, which skills were used (if any), the damage done, defender’s health left.

If we have a winner before the maximum number of rounds is reached, he must be declared


## Install and run application
PHP in version at least 7.1.15 needs to be installed and running.

Application runs in CLI

```bash
git clone git@github.com:tomekpiasecki/hero-game.git

# install composer dependencies
cd hero-game
composer install

# run the application from command line
php -f cli/index.php
``` 
Output presenting the course of the game will be displayed in command line

## Development
Components used in application:

### Unit tests
```bash
# without coverage
./vendor/bin/phpunit --color --no-coverage

# generate coverage report in `testReports/coverage.html`
./vendor/bin/phpunit --color
```

### Code Sniffer
```bash
./vendor/bin/phpcs ./src --colors --standard=phpcs-ruleset.xml
``` 