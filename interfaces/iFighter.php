<?php

namespace interfaces;


interface iFighter
{
    const MIN_SKILL = 1;
    const MAX_SKILL = 10;
    const SUM_SKILLS = 20;

    const MIN_HP = 30;
    const MAX_HP = 70;
    const MAX_AVOIDANCE_CHANCE = 60;

    const DAMAGE_PER_STR = 0.1;

    public function __construct();
}
