<?php

require_once "./Role/Role.php";

class Parti
{
    private int $gameRound;
    private array $playerList;


    public function __construct(array $playerList)
    {
        $this->playerList = $playerList;
        $this->gameRound = 1;

    }

    public function launch(): void
    {
        while (true) {
            $this->cupidonTurn();
            $this->wolfTurn();
            $this->witchTurn();
            $this->psyTurn();
            $this->killPlayer();
            $this->resolveRole();
            if($this->gameRound == 1)
                $this->electionTurn();
            $this->democratieTurn();
            $this->resolveRole();
            $this->gameRound++;
        }
    }


    private function cupidonTurn(): void
    {
        if ($this->gameRound == 1) {
            echo "
        //-------------------------------------//
        //------- Cupidon ce reveille ---------//
        //-------------------------------------//\n
        ";
            foreach ($this->playerList as $player) {
                if (!$player->isDead())
                    $player->whenCupidionPlay($this->getPlayerInLife());
            }
        }
    }

    private function wolfTurn(): void
    {
        echo "
        //-------------------------------------//
        //--- Les Loups Garou ce reveillent ---//
        //-------------------------------------//\n
        ";
        $nbrWolf = 0;
        foreach ($this->playerList as $player) {
            if (!$player->isDead()) {
                $player->whenLoupPlay($this->getPlayerInLife());
                $nbrWolf++;
            }
        }
        if ($nbrWolf !== 0) {
            $this->getMaxVote()->gonnaDied();
            $this->resetVote();
        }

    }

    private function witchTurn(): void
    {
        echo "
        //-------------------------------------//
        //----- La Sorcière ce réveille -------//
        //-------------------------------------//\n
        ";
        foreach ($this->playerList as $player) {
            if (!$player->isDead())
                $player->whenWitchPlay($this->getPlayerInLife());
        }
    }

    private function psyTurn(): void
    {
        echo "
        //-------------------------------------//
        //------ La Voyante ce réveille -------//
        //-------------------------------------//\n
        ";
        foreach ($this->playerList as $player) {
            if (!$player->isDead())
                $player->whenPsyPlay($this->getPlayerInLife());
        }
    }

    private  function electionTurn(): void
    {
        echo "
        //------------------------------------------//
        //--- Le village vote pour élire un Maire --//
        //------------------------------------------//
        ";
        foreach ($this->playerList as $player) {
            if (!$player->isDead())
                $player->whenVote($this->getPlayerInLife());
        }
        $this->getMaxVote()->yesYouCan();
        $this->resetVote();
    }

    private function democratieTurn(): void
    {
        echo "
        //------------------------------------------//
        //- Le village vote pour tuer un habittant -//
        //------------------------------------------//
        ";
        foreach ($this->playerList as $player) {
            if (!$player->isDead())
                $player->whenVote($this->getPlayerInLife());
        }
        $this->getMaxVote()->onDead($this->playerList);
        $this->resetVote();
    }

    private function killPlayer()
    {
        echo "\n\n
        //--------------------------------------------//
        //- Le village ce reveille d'une longue nuit -//
        //--------------------------------------------//\n\n
        ";
        $nbrKill = 0;
        echo "Cette nuit .";
        sleep(1);
        echo ".";
        sleep(1);
        echo ".";
        sleep(1);
        foreach ($this->playerList as $player) {
            if ($player->isGonnaDead()) {
                $nbrKill++;
                echo $player->getPlayerName() . " est mort!\n";
                $player->onDead($this->getPlayerInLife());
            }
        }
        if ($nbrKill == 0)
            echo " Le village a garder tout les membres!!";
    }

    private function resolveRole(): void
    {
        $camps = [];
        if ($this->getCampsRole(0)) {
            $camps[] = 0;
        };
        if ($this->getCampsRole(1)) {
            $camps[] = 1;
        };
        if ($this->getCampsRole(2)) {
            $camps[] = 2;
        };
        if (count($camps) == 1) {

            echo "//-------------------------------------//\nPartie Fini\n";
            echo "Les ".Role::getCampById($camps[0])." ont gané!!!";
            exit();
        }

    }

    private function getCampsRole($id): bool
    {
        foreach ($this->playerList as $player) {
            if (!$player->isDead() and $player->getCamp() == $id) {
                return true;
            }
        }
        return false;
    }

    private function getMaxVote(): Role
    {
        $return = $this->playerList[0];
        foreach ($this->playerList as $player) {
            if (!$player->isDead() and $return->getVote() < $player->getVote()) {
                $return = $player;
            }
        }
        return $return;
    }

    private function resetVote(): void
    {
        foreach ($this->playerList as $player) {
            $player->resetVote();
        }
    }

    private function getPlayerInLife(): array
    {
        return array_filter($this->playerList, function ($k) {
            return !$k->isDead();
        });
    }

}