<?php

namespace controllers;


use models\Arena;
use models\RandomFighter;

class ArenaController extends Arena
{
    public function fightBetweenRandomFighters()
    {
        $this->setFighters(new RandomFighter(), new RandomFighter());
        $this->fight();
    }
}
