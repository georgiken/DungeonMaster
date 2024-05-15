<?php

class DungeonLogic {
    private $map = [];
    private $player;
    private $shortestPath = [];

    public function __construct($mapData, $startRoomIndex) {
        $this->loadMap($mapData);
        $this->player = new Player($this->map[$startRoomIndex]);
    }

    private function loadMap($mapData) {
        // Создаю всё подземелье
        foreach ($mapData as $roomData) {
            $room = new Room($roomData['type'], $roomData['content']);
            $this->map[] = $room;
        }

        // Связываю комнаты между собой
        foreach ($mapData as $index => $roomData) {
            foreach ($roomData['doors'] as $direction => $neighborIndex) {
                $this->map[$index]->addDoor($direction, $this->map[$neighborIndex]);
            }
        }
    }

    public function movePlayer($direction) {
        $currentRoom = $this->player->getCurrentRoom();
        $newRoom = $currentRoom->getDoor($direction);

        if ($newRoom) {
            $this->player->setCurrentRoom($newRoom);
            $this->processRoomContent($newRoom);
            $this->shortestPath[] = $direction;
        } else {
            throw new Exception('No door in that direction.');
        }
    }

    private function processRoomContent($room) {
        if (!$room->isVisited()) {
            $room->visit();
            $content = $room->getContent();
    
            switch ($room->getType()) {
                case 'chest':
                    $points = $content['points'];
                    $this->player->addToScore($points);
                    break;
                case 'monster':
                    $strength = $content['strength'];
                    // Бой с монстром
                    while ($strength > 0) {
                        $playerRoll = mt_rand(1, 1000); // Генерирую случайное число для игрока
                        $monsterRoll = mt_rand(1, 1000); // Генерирую случайное число для монстра
    
                        if ($playerRoll > $monsterRoll) {
                            // Игрок победил монстра
                            $this->player->addToScore($strength);
                            break;
                        } else {
                            switch($content['content']){// Монстр побеждает, уменьшаем его силу
                                case 'goblin':
                                    $strength-=10;
                                    break;
                                case 'minotaur':
                                    $strength--;
                                    break;
                                //остальные типы монстров и их уменьшение силы
                            }
                            
                        }
                    }
                    break;
            }
        }
    }

    public function getFinalScore() {
        return $this->player->getScore();
    }

    public function getShortestPath() {
        return $this->shortestPath;
    }

    public function findShortestPath($startRoomIndex, $endRoomIndex) {
        $visited = array_fill(0, count($this->map), false);
        $queue = new SplQueue();
        $prev = array_fill(0, count($this->map), null);

        $visited[$startRoomIndex] = true;
        $queue->enqueue($startRoomIndex);

        while (!$queue->isEmpty()) {
            $roomIndex = $queue->dequeue();

            foreach ($this->map[$roomIndex]->getDoors() as $direction => $neighbor) {
                $neighborIndex = array_search($neighbor, $this->map, true);
                if ($neighborIndex !== false && !$visited[$neighborIndex]) {
                    $visited[$neighborIndex] = true;
                    $queue->enqueue($neighborIndex);
                    $prev[$neighborIndex] = $roomIndex;
                }
            }
        }

        $path = [];
        for ($current = $endRoomIndex; $current !== null; $current = $prev[$current]) {
            $path[] = $current;
        }
        $this->shortestPath = array_reverse($path);
    }
}

?>
