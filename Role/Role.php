<?php

abstract class Role
{
    protected const ROLE_ENUM = ["Villageois", "Loups", "Amoureux"];
    protected string $name, $playerName;
    protected int $camp, $vote;
    protected bool $isMaire, $isDead, $gonnaDead;

    static array $playerList = [];

    public function __construct(string $playerName, string $name, int $camp)
    {
        $this->playerName = $playerName;
        $this->name = $name;
        $this->camp = $camp;
        $this->vote = 0;
        $this->isMaire = false;
        $this->isDead = false;
        $this->gonnaDead = false;
        self::$playerList[] = $this;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getCamp(): string
    {
        return $this->camp;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function getVote(): int
    {
        return $this->vote;
    }

    public function isMaire(): bool
    {
        return $this->isMaire;
    }

    public function isDead(): bool
    {
        return $this->isDead;
    }

    public function isGonnaDead(): bool
    {
        return $this->gonnaDead;
    }

    //Section Vote
    public function voteFor(Role $player): void
    {
        $player->addVote();
        if ($this->isMaire)
            $player->addVote();
    }

    public function addVote(): void
    {
        $this->vote++;
    }

    public function resetVote(): void
    {
        $this->vote = 0;
    }

    public function yesYouCan(): void
    {
        $this->isMaire = true;
        echo $this->playerName." est élu Maire!!\n\n";
        sleep(2);
    }

    // Vote Role Function

    public function whenVote(array $list): void
    {
        echo "\n- ".$this->playerName." a toi de jouer\n\n";
        $indexP1 = null;
        while ($indexP1 == null) {
            echo "Pour qui voulez vous voter aujourd'hui?\n";
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
        $this->voteFor($indexP1);
    }

    // Custome Role Function
    public function whenCupidionPlay(array $list): void
    {

    }

    public function whenLoupPlay(array $list): void
    {
    }

    public function whenWitchPlay(array $list): void
    {

    }

    public function whenPsyPlay(array $list): void
    {

    }

    public function onDead(array $list)
    {
        echo $this->playerName . " était.";
        sleep(1);
        echo ".";
        sleep(1);
        echo ".";
        sleep(1);
        echo "  " . $this->name . "!!\n";
        $this->isDead = true;
        if ($this->camp == 2) {

            foreach ($list as $player) {
                if (!$player->isDead() and $player->getCamp() == 2) {
                    sleep(1);
                    echo "Mais " . $this->playerName . " était amoureux de.";
                    sleep(1);
                    echo ".";
                    sleep(1);
                    echo ".  ";
                    sleep(1);
                    echo $player->getPlayerName() . "!!\n";
                    $player->onDead($list);
                }

            }
        }
    }

    public function tombeInLove(Role $amour)
    {
        echo "\n Vous êtes tomber fou amoureux de " . $amour->getPlayerName() . "!\n";
        sleep(1);
        $this->camp = 2;
    }

    public function gonnaDied()
    {
        $this->gonnaDead = true;
    }

    public function revive()
    {
        $this->gonnaDead = false;
    }


    public static function getCampById($id): string
    {
        return self::ROLE_ENUM[$id];
    }

}