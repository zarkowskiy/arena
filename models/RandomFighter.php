<?php

namespace models;


class RandomFighter extends Fighter
{
    /**
     * RandomFighter constructor.
     */
    public function __construct()
    {
        $this->setRandomSkills();

        $unique = uniqid('', true);
        $uid = substr($unique, strlen($unique) - 3, strlen($unique));

        parent::__construct('Fighter ' . $uid);
    }

    /**
     * Generate and set random skills for fighter
     */
    private function setRandomSkills()
    {
        $str = rand(self::MIN_SKILL, self::MAX_SKILL);

        $diffDex = ((self::SUM_SKILLS - self::MIN_SKILL) - $str);
        $max = ($diffDex < self::MAX_SKILL) ? $diffDex : self::MAX_SKILL;
        $dex = rand(self::MIN_SKILL, $max);

        $diffCon = self::SUM_SKILLS - ($str + $dex);
        if ($diffCon < self::MAX_SKILL) {
            $con = $diffCon;
        } else {
            $con = self::MAX_SKILL;
            $str += (int) floor(($diffCon - self::MAX_SKILL) / 2);
            $dex += (int) ceil(($diffCon - self::MAX_SKILL) / 2);
        }
        $this->str = $str;
        $this->dex = $dex;
        $this->con = $con;
    }
}
