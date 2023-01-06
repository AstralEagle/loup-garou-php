<?php

include_once("Role.php");

class Villageoi extends Role
{


    public function __construct(string $playerName)
    {
        parent::__construct($playerName, "Villageoi", 0);
    }


}