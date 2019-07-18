<?php
require_once('./schedule.php');

class SessionSchedule {
    function __construct($days) {
        $this->items = array();
        foreach($days as $day) {
            $this->items[] = new SessionScheduleItem($day);
        }
    }
    function getJson() {
        return json_encode($this->items, JSON_UNESCAPED_UNICODE);
    }
}

class SessionScheduleItem {
    function __construct($day) {
        $this->date = $day->date;
        $this->big_hall = array();

        foreach ($day->items as $film) {
            $newItem = new SessionScheduleFilm($film); 
            $this->big_hall[] = $newItem->toString();
        }
    }
}

class SessionScheduleFilm {
    function __construct($film) {
        $this->film = $film;
    }
    function toString() {
        $str = preg_replace("/(\d\d:\d\d)/" , "<b>\\1</b>" , $this->film->text);
        return preg_replace("/(\(\d.*р\))/" , "<b>\\1</b>" , $str);
    }
}


$response = new SunnyResponse(207);
$sessions = new SessionSchedule($response->result);
echo $sessions->getJson();





