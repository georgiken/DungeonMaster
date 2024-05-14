<?php

class Dungeon {
//Main class which includes logic of map creating, fighting, player moving,
//finding the most efficient way, saving score
    private $map;
    private $player;
    private $path = [];

    public function __construct($mapData, $startRoomIndex) {
        $this->loadMap($mapData);
        $this->player = new Player($this->map[$startRoomIndex]);
    }

    private function loadMap($mapData) {
        foreach ($mapData as $roomData) {
            $room = new Room($roomData['type'], $roomData['content']);
            $this->map[] = $room;
        }

        // Связываем комнаты между собой
        for ($i = 0; $i < count($mapData); $i++) {
            foreach ($mapData[$i]['doors'] as $direction) {
                $this->map[$i]->addDoor($direction, $this->map[$i + 1]);
            }
        }
    }

    public function movePlayer($direction) {
        $currentRoom = $this->player->getCurrentRoom();
        $this->path[] = $direction;

        $newRoom = $currentRoom->getDoor($direction);

        if ($newRoom) {
            $this->player->setCurrentRoom($newRoom);
            $this->processRoomContent($newRoom);
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
        return $this->path;
    }
}

?>
