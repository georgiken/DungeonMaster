<?php

class Player {
//player class which includes player parameters(currentRoom, score),
//constructor(at start player in startRoom and have 0 points) 
//and methods(getCurrentRoom, setCurrentRoom, getScore, addToScore)
  
    private $currentRoom;
    private $score;

    public function __construct($startRoom) {
        $this->currentRoom = $startRoom;
        $this->score = 0;
    }

    public function getCurrentRoom() {
        return $this->currentRoom;
    }

    public function setCurrentRoom($room) {
        $this->currentRoom = $room;
    }

    public function getScore() {
        return $this->score;
    }

    public function addToScore($points) {
        $this->score += $points;
    }
}
?>
