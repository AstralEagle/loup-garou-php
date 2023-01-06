<?php
require_once "Role.php";

class Sorciere extends Role
{
    private bool $potDead, $potLife;

    public function __construct(string $playerName)
    {
        parent::__construct($playerName, "Sorcière", 0);
        $this->potLife = true;
        $this->potDead = true;
    }

    public function whenWitchPlay(array $list): void
    {
        /*
         * Afficher la personne qui vien de mourir
         * Offrire le choix de : tuer, sauver et ne rien faire
         *
         * Tuer:
         * Afficher la list des personne
         * Selectionne une personne
         * Lui mettre gonnaDead
         * this pot = false
         *
         * Sauver:
         * Lui retirer gonaDead
         * this pot = false
         *
         * Ne Rien faire:
         * Si aucun pot ne pas afficher le choix
        */
        echo "- ".$this->playerName." a toi de jouer\n";
        $infinity = true;
        $gonnaDead = $list[0];
        foreach ($list as $player){
            if($player->isGonnaDead()){
                $gonnaDead = $player;
                break;
            }
        }
        while($infinity)
        if($this->potLife or $this->potDead){

            if($this->potLife)
                echo "\n- ".$gonnaDead->getPlayerName()." va mourir si vous ne faite rien.\n";
            echo "\nVoulez vous utiliser une potion?\n1- Sauver\n2- Tuer\n3- Ne rien faire\n";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            switch (trim($line)){
                case 1:
                    if($this->potLife){
                    $gonnaDead->revive();
                    $this->potLife = false;
                    }
                    else{
                        echo "Vous ne possedez plus cette potion...\n";
                    }
                    break;
                case 2:
                    if($this->potDead){
                        $this->killPlayer($list);
                        $this->potDead = false;
                    }
                    else
                        echo "Vous ne possedez plus cette potion...\n";
                    break;
                case 3:
                    $infinity = false;
                    break;
                default:
                    break;
            }
            fclose($handle);
        }
        else{
            $infinity = false;
        }
    }
    private function killPlayer(array $list): void
    {
        while (true) {
            echo "Qui voulez vous tuer?\n";
            foreach ($list as $index => $player) {
                echo $index . " - " . $player->getPlayerName() . "\n";
            }
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            if (is_int(intval(trim($line)))) {
                $list[trim($line)]->gonnaDied();
                break;
            }
            fclose($handle);
        }

    }
}