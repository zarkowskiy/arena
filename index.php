<?php

include 'autoload.php';

use controllers\ArenaController;


$arena = new ArenaController();
$arena->fightBetweenRandomFighters();
