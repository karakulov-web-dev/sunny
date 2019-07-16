<?php
require_once('./schedule.php');
require_once('./FilmContainer.php');



$response = new SunnyResponse(212);
$today = new FilmContainer($response->result);
echo json_encode($today->items, JSON_UNESCAPED_UNICODE);







