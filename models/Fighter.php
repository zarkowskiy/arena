<?php

namespace models;

use interfaces\iFighter;

abstract class Fighter implements iFighter
{
    protected $str;
    protected $dex;
    protected $con;

    public $name;

    public $hp;
    public $avoidance;
    public $damage;

    public $currentHP;

    /**
     * Fighter constructor.
     * @param string $name
     */
    public function __construct($name = '')
    {
        $this->hp = $this->calculateHP();
        $this->avoidance = $this->calculateAvoidance();
        $this->damage = $this->calculateDamage();
        $this->currentHP = $this->hp;
        $this->name = $name;
    }

    /**
     * @return float|int
     */
    private function calculateHP()
    {
        return (self::MIN_HP + (((self::MAX_HP - self::MIN_HP)/self::MAX_SKILL) * $this->con));
    }

    /**
     * @return float|int
     */
    private function calculateAvoidance()
    {
        return ((self::MAX_AVOIDANCE_CHANCE/self::MAX_SKILL) * $this->dex);
    }

    /**
     * @return float|int
     */
    private function calculateDamage()
    {
        return (self::DAMAGE_PER_STR * $this->str);
    }
}
