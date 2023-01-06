<?php
require_once "Role.php";
class Voyante extends Role
{
    public function __construct(string $playerName)
    {
        parent::__construct($playerName, "Voyante", 0);
    }

    public function whenPsyPlay(array $list): void
    {
        /*
         * Afficher la List des joueur
         * Choisir une personne et voir son Role
         */
        echo "- ".$this->playerName." a toi de jouer\n\n";
        $indexP1 = null;
        while ($indexP1 == null) {
            echo "Qui voulez vous espionner cette nuit?\n";
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
        echo "Vous voyez que ".$indexP1->getPlayerName()." est ".$indexP1->getName()."\n";
        sleep(2);

    }

}