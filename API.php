<?php

class DungeonAPI {
    private $dungeon;

    public function __construct($mapData, $startRoomIndex) {
        $this->dungeon = new Dungeon($mapData, $startRoomIndex);
    }

    public function startGame() {
        echo "Игра началась!\n";
        echo "Вы находитесь в стартовой комнате.\n";
    }

    public function movePlayer($direction) {
        try {
            $this->dungeon->movePlayer($direction);
            echo "Вы переместились в направлении $direction.\n";
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

   public function endGame() {
        $finalScore = $this->dungeon->getFinalScore();
        $shortestPath = $this->dungeon->getShortestPath();

        echo "Игра окончена!\n";
        echo "Ваш итоговый счет: $finalScore.\n";
        echo "Кратчайший путь прохождения подземелья: " . implode(' -> ', $shortestPath) . ".\n";
    }

    public function findShortestPath($startRoomIndex, $endRoomIndex) {
        $this->dungeon->findShortestPath($startRoomIndex, $endRoomIndex);
    }

?>
