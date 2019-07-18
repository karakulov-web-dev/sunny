<?php
require_once('./ReqTools.php');


class SunnySchedule {
        function __construct($id, $title, $introText, $fullText ) {
            $this->id = $id;
            $this->title = $title;
            $this->introText = $introText;
            $this->fullText = $fullText;
            $this->unionText = $introText.$fullText;
            $this->items = array();
            $this->days = array();
    }
    function breakIntoParagraphs() {
        $this->paragraphs = explode("</p>",$this->unionText);
    }
    function textToObject() {
        foreach ($this->paragraphs as $value) {
            if (stripos($value, "strong")) {
                $this->items[] = new ScheduleItem($value);
            }
        }
        foreach ($this->items as $key => $item) {
            if ($item->id) {
               $lastIndex = count($this->days) - 1;
               $this->days[$lastIndex]->add($item);
            } else {
                if (preg_replace('/\D/', '', $item->text)) {
                    $this->days[] = $item;
                }
            }
        }
    }
}

class ScheduleItem  {
    function __construct($text) {
        $this->text = $text;
        $this->getId();
        $this->text = strip_tags($this->text);
        $this->text = str_replace("&nbsp;"," ", $this->text);
        $this->items = array();
        $this->text = trim($this->text);
        if ($this->id) {
            $this->body = new ScheduleItemBody($this->id);
        }
        if (!$this->id) {
            $this->date = $this->text;
        }
    }
    function getId() {
        $pos = stripos($this->text, "id=");
        $ss = substr($this->text, $pos + 3, 5);
        $int = (int) preg_replace('/\D/', '', $ss);
        if ($int) {
            $this->id = $int;
        }
    }
    function add($item) {
        $this->items[] = $item;
        $item->deleteItems();
    }
    function deleteItems() {
        unset($this->items);
    }
}


class ScheduleItemBody {
    function __construct($id) {

    $reqTools = new ReqTools();
    $result = $reqTools->reqDb("SELECT * FROM `sol_content` WHERE `id`=$id");


        $this->title = $result[0]["title"];
        $this->_introText = $result[0]["introtext"];
        $this->_fulltext = $result[0]["fulltext"];
        $this->_concatText =  $this->_introText.$this->_fulltext;
        $this->breakIntoParagraphs();
        $this->images = json_decode($result[0]["images"]);
        foreach ($this->_paragraphs as &$item) {
            $item = strip_tags($item);
        }
        $this->date = trim(str_replace("&nbsp;","", $this->_paragraphs[0]));
        $this->description = trim($this->_paragraphs[2]);

        $this->_paragraphs[1] = str_replace("&nbsp;","", $this->_paragraphs[1]);
        $this->year = $this->matchInParagraph('/Год:(....)/', 0);
        $this->genre = $this->matchInParagraph('/Жанр:(.*)Страна/', 0);
        $this->country = $this->matchInParagraph('/Страна:(.*)Возраст/', 0);
        $this->age = $this->matchInParagraph('/Возраст:(.*)Режиссер/', 0);
        $this->producer = $this->matchInParagraph('/Режиссер:(.*)Актеры/', 0);
        $this->actors = $this->matchInParagraph('/Актеры:(.*)/', 0);
        $this->youtubeId = $this->matchInParagraph('/{youtube}(.*){\/youtube}/' , $this->_concatText);
        if ($this->youtubeId == "Нет данных") {
            $this->youtubeId = $this->matchInParagraph('/{youtube}(.*){\/youtube}/' , $this->_concatText);
        }
        $gallery = $this->matchInParagraph('/{gallery}(.*):180:180/' , $this->_paragraphs[4]);
        if ($gallery == "Нет данных") {
            $gallery = $this->matchInParagraph('/{gallery}(.*):180:180/' , $this->_concatText);
        }
        $this->images->image_fulltext = "http://xn--42-mlcqimbe0a8d2b.xn--p1ai/images/".$gallery."/1.jpg";
        $this->images->image_intro = "http://xn--42-mlcqimbe0a8d2b.xn--p1ai/images/".$gallery."/1.jpg";
        unset($this->_paragraphs);
        unset($this->_concatText);
    }
    function breakIntoParagraphs() {
        $this->_paragraphs = explode("</p>", $this->_concatText);
        unset($this->_introText);
        unset($this->_fulltext);
    }
    function matchInParagraph($regExp, $paragraph) {
        if (!$paragraph) {
            $paragraph = $this->_paragraphs[1];
        }
        $status = preg_match($regExp, $paragraph, $matches, PREG_OFFSET_CAPTURE);
        if ($status) {
            $value = $matches[1][0];
        } else {
            $value = "Нет данных";
        }
        return trim($value);
    }
}
class SunnyResponse {
    function __construct($dataId) {

    $reqTools = new ReqTools();
    $result = $reqTools->reqDb("SELECT * FROM `sol_content` WHERE `id`=$dataId");

    $schedule = new SunnySchedule($dataId,$result[0]["title"],$result[0]["introtext"], $result[0]["fulltext"]);
    $this->error = false;
    $this->result = array();
    try {
        $schedule->breakIntoParagraphs();
        $schedule->textToObject();
        $this->result = $schedule->days;
    } catch (Exception $e) {
        $this->error =  'Исключение: '.$e->getMessage()."\n";
    }
    }
    function send() {
        echo json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}

