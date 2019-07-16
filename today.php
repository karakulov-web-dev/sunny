<?php
require_once('./schedule.php');
require_once('./FilmContainer.php');

$response = new SunnyResponse(207);
$today = new FilmContainer($response->result);
echo json_encode($today->items, JSON_UNESCAPED_UNICODE);








