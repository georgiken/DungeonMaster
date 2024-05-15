<?php

require_once 'API.php';

$mapData = [
    [
        'type' => 'start',
        'content' => [],
        'doors' => ['east' => 1, 'south' => 3]
    ],
    [
        'type' => 'chest',
        'content' => ['points' => 5],
        'doors' => ['west' => 0, 'south' => 4]
    ],
    [
        'type' => 'monster',
        'content' => ['type' => 'goblin', 'strength' => 3],
        'doors' => ['west' => 1, 'east' => 5]
    ],
    [
        'type' => 'empty',
        'content' => [],
        'doors' => ['north' => 0, 'east' => 4]
    ],
    [
        'type' => 'exit',
        'content' => [],
        'doors' => ['north' => 1, 'west' => 3]
    ]
];

$dungeonAPI = new API($mapData, 0);
$dungeonAPI->startGame();
$dungeonAPI->movePlayer('east');
$dungeonAPI->movePlayer('south');
$dungeonAPI->findShortestPath(0, 4);
$dungeonAPI->endGame();

?>
