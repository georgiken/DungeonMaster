<?php

class Room {
    private $type;
    private $visited;
    private $content;
    private $doors = [];

    public function __construct($type, $content) {
        $this->type = $type;
        $this->visited = false;
        $this->content = $content;
    }

    public function getType() {
        return $this->type;
    }

    public function isVisited() {
        return $this->visited;
    }

    public function visit() {
        $this->visited = true;
    }

    public function getContent() {
        return $this->content;
    }

    public function addDoor($direction, $room) {
        $this->doors[$direction] = $room;
    }

    public function getDoor($direction) {
        return isset($this->doors[$direction]) ? $this->doors[$direction] : null;
    }

    public function getDoors() {
        return $this->doors;
    }
}
?>
