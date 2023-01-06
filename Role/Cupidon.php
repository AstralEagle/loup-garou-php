<?php
require_once "Role.php";

class Cupidon extends Role
{
    private bool $arrowLove;

    public function __construct(string $playerName)
    {
        $this->arrowLove = true;
        parent::__construct($playerName, "Cupidon", 0);
    }

    public function whenCupidionPlay(array $list): void
    {
        /*
         * Si arrowLove = true
         * Afficher les list des joueur
         * Choisir une personn
         * Afficher la list des personne sans le premier choix
         * Choisir une autre personne
         * Leur faire change de camps en 3
         * this arrowLove = false
         */
        echo "- ".$this->playerName." a toi de jouer\n\n";
        if ($this->arrowLove === true) {
            $indexP1 = null;
            $indexP2 = null;
            echo "Vous êtes Cupidon! \nSelectionnez 2 personne qui tomberont fou amoureux\n";
            while ($indexP1 == null) {
                echo "Entrez le premier amoureux\n";
                foreach ($list as $index => $player) {
                    echo $index . " - " . $player->getPlayerName() . "\n";
                }
                $handle = fopen("php://stdin", "r");
                $line = fgets($handle);
                if (is_int(intval(trim($line))) and trim($line) < count($list)) {
                    $indexP1 = $list[trim($line)];
                }
                fclose($handle);
            }
            $list = array_filter($list, function ($k) use ($indexP1) {
                return $k !== $indexP1;
            });
            while ($indexP2 == null) {
                echo "Entrez le deuxieme amoureux\n";
                foreach ($list as $index => $player) {
                    echo $index . " - " . $player->getPlayerName() . "\n";
                }
                $handle = fopen("php://stdin", "r");
                $line = fgets($handle);
                if (is_int(intval(trim($line)))) {
                    $indexP2 = $list[trim($line)];
                }
                fclose($handle);
            }
            $indexP1->tombeInLove($indexP2);
            $indexP2->tombeInLove($indexP1);
            echo "Amoureu 1 : ".$indexP1->getCamp();
            echo "Amoureu 2 : ".$indexP2->getCamp();
            $this->arrowLove = false;
            sleep(2);

        }
    }
}