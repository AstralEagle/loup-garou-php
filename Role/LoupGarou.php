<?php
require_once "Role.php";

class LoupGarou extends Role
{
    public function __construct(string $playerName)
    {
        parent::__construct($playerName, "Loup", 1);
    }
    public function whenLoupPlay(array $list):void
    {
        /*
         * Afficher la list des Loups
         * Choisir Une Victime par vote
        */
        echo "- ".$this->playerName." a toi de jouer\n\n";
        $indexP1 = null;
        while ($indexP1 == null) {
            echo "Les loups sont:\n";
            foreach ($list as $index => $player) {
                if($player->getName() == "Loup")
                    echo "- ".$player->getPlayerName() . "\n";
            }
            echo "\nQui voulez vous dévorez cette nuit?\n";
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
        $indexP1->addVote();
    }
}