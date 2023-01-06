<?php

class Chasseur extends Role
{
    public function __construct(string $playerName)
    {
        parent::__construct($playerName, "Chasseur", 0);
    }

    public function onDead(array $list)
    {
        parent::onDead($list);
        echo "
        //-------------------------------------//
        //---- Le chasseur sort son fusil -----//
        //-------------------------------------//\n
        ";
        echo "- ".$this->playerName." a toi de jouer\n\n";
        $list = array_filter($list, function ($k) {
            return !$k->isDead();
        });
        $indexP1 = null;
        while ($indexP1 == null) {
            echo "Qui voulez vous Amener avec vous dans la tombe?\n";
            foreach ($list as $index => $player) {
                echo $index . " - " . $player->getPlayerName() . "\n";
            }
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            if (is_int(intval(trim($line)))) {
                $indexP1 = $list[trim($line)];
            }
            fclose($handle);
        }
        $indexP1->onDead($list);

        /*
         * Selectionner un joueur
         */
    }
}