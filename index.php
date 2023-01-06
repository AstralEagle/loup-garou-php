<?php

include_once("./Role/Villageoi.php");
include_once("./Role/LoupGarou.php");
include_once("./Role/Voyante.php");
include_once("./Role/Sorciere.php");
include_once("./Role/Cupidon.php");
include_once("./Role/Chasseur.php");
include_once "Parti.php";



$player = [];
$player1 = new Chasseur("Anna");
$player2 = new Voyante("Carlos");
$player3 = new Sorciere("William");
$player4 = new Villageoi("Xavier");
$player5 = new Villageoi("Yanis");
$player6 = new LoupGarou("Zoe");
$player[] = $player1;
$player[] = $player2;
$player[] = $player3;
$player[] = $player4;
$player[] = $player5;
$player[] = $player6;

$parti = new Parti($player);
$parti->launch();



