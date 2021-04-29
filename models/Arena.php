<?php
namespace models;

use interfaces\iArena;

abstract class Arena implements iArena
{
    private $firstFighter;
    private $secondFighter;

    /**
     * @param Fighter $firstFighter
     * @param Fighter $secondFighter
     */
    protected function setFighters(Fighter $firstFighter, Fighter $secondFighter)
    {
        $this->firstFighter = $firstFighter;
        $this->secondFighter = $secondFighter;
    }

    protected function fight()
    {
        $this->log('Start fight!');
        if (!is_null($this->firstFighter) && !is_null($this->secondFighter)) {
            $table = [];

            for ($i = 1; $i <= self::COUNT_ROUNDS; $i++)
            {
                $this->log('');
                $this->log("Round {$i}. Fight!");
                $table[$i] = $this->round();
                $this->log("Round {$i} finish!");
                $this->log('');
            }

            $counts = array_count_values($table);

            $firstWins = $counts[$this->firstFighter->name];
            $secondWins = $counts[$this->secondFighter->name];

            if ($firstWins === $secondWins) {
                $this->log("According to the results of ".self::COUNT_ROUNDS." rounds - a draw");
            }

            if ($firstWins > $secondWins) {
                $this->log("According to the results of ".self::COUNT_ROUNDS." rounds - {$this->firstFighter->name} WIN!");
            } else if ($firstWins < $secondWins) {
                $this->log("According to the results of ".self::COUNT_ROUNDS." rounds - {$this->secondFighter->name} WIN!");
            }
        }
        $this->log('End fight!');
    }

    /**
     * @return string
     */
    private function round()
    {
        $firstFighter = clone($this->firstFighter);
        $secondFighter = clone($this->secondFighter);

        do {
            $this->log('-------------------------------');
            $this->log("{$firstFighter->name} HP: {$firstFighter->currentHP}. {$secondFighter->name} HP: {$secondFighter->currentHP}.");
            $this->hit($firstFighter, $secondFighter);
            $this->hit($secondFighter, $firstFighter);
            $this->log("{$firstFighter->name} HP: {$firstFighter->currentHP}. {$secondFighter->name} HP: {$secondFighter->currentHP}.");
            $this->log('-------------------------------');
        } while (($firstFighter->currentHP > 0) && ($secondFighter->currentHP > 0));

        if ($firstFighter->currentHP < 0 && $secondFighter->currentHP < 0) {
            return 'draw';
        }

        if ($firstFighter->currentHP > 0) {
            return $firstFighter->name;
        }

        if ($secondFighter->currentHP > 0) {
            return $secondFighter->name;
        }
    }

    /**
     * @param Fighter $attacker
     * @param Fighter $defender
     */
    private function hit(Fighter $attacker, Fighter $defender)
    {
        $avoidance_dice = rand(1, 100);
        $damage_percent = 1;

        if ($this->isDodged($defender, $avoidance_dice)) {
            $this->log("{$defender->name} dodged!");
            return;
        }

        if ($this->isPartDodged($defender, $avoidance_dice)) {
            $this->log("{$defender->name} part dodged!");
            $damage_percent = self::DODGED_DAMAGE;
        }

        $damage = ($attacker->damage * $defender->hp) * $damage_percent;

        $this->log("$attacker->name inflicted {$damage} damage");
        $defender->currentHP -= $damage;
    }

    /**
     * @param Fighter $defender
     * @param $dice
     * @return bool
     */
    private function isDodged(Fighter $defender, $dice)
    {
        return ($dice <= $defender->avoidance * self::DODGE_PART);
    }

    /**
     * @param Fighter $defender
     * @param $dice
     * @return bool
     */
    private function isPartDodged(Fighter $defender, $dice)
    {
        return ($dice <= $defender->avoidance);
    }

    /**
     * @param $string
     */
    private function log($string) {
        echo $string . "<br>";
    }
}
