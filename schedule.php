<?php

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
        $this->title = "\"Лови момент\" комедия, Россия, 16+, 2D";
        $this->_introText = "<p><strong><span style=\"font-size: 14pt; color: #ff0000;\">с 27 июня по 3 июля</span></strong></p>
<p><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Год:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">&nbsp;2019</span><br style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\" /><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Жанр:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\"> комедия<br /></span><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Страна:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">&nbsp;Россия<br /></span><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Возраст:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">&nbsp;16+<br /></span><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\"><strong>Режиссер</strong>: Антонина Руже<br /><strong>Актеры</strong>: Юлия Топольницкая, Алексей Весёлкин, Валерия Федорович, Юрий Быков, Михаил Тарабукин, Юлия Сулес, Ольга Кузьмина, Ингрид Олеринская, Валерия Дергилева, Катя Кабак, Михаил Козырев, Алексей Кортнев<br /></span><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Время:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">&nbsp;81 мин.&nbsp;</span></p>
<section class=\"release-card-section\">
<section class=\"release-card-section\">";
        $this->_fulltext = "<p class=\"release-card__description\">Главная героиня — милая амбициозная девушка Рита из провинциального городка на черноморском побережье. Она решает вырваться из рутины ведения местных свадеб и утренников и приезжает покорять столицу, пытаясь поступить в театральное училище. Ее ждет много сложных испытаний, которые порой превращаются в очень комичные истории.</p>
</section>
</section>
<p>{youtube}L4_5jaeZ0q0{/youtube}</p>
<p>{gallery}kino/lovi moment:180:180:0:0{/gallery}</p>";
        $this->_concatText =  $this->_introText.$this->_fulltext;
        $this->breakIntoParagraphs();
        $this->images = json_decode("{\"image_intro\":\"images\\/kino\\/lovi moment\\/28408.jpg\",\"float_intro\":\"none\",\"image_intro_alt\":\"\",\"image_intro_caption\":\"\",\"image_fulltext\":\"images\\/kino\\/lovi moment\\/28409.jpg\",\"float_fulltext\":\"none\",\"image_fulltext_alt\":\"\",\"image_fulltext_caption\":\"\"}");
        $this->images->image_intro = "http://xn--42-mlcqimbe0a8d2b.xn--p1ai/".$this->images->image_intro;
        $this->images->image_fulltext = "http://xn--42-mlcqimbe0a8d2b.xn--p1ai/".$this->images->image_fulltext;
        foreach ($this->_paragraphs as &$item) {
            $item = strip_tags($item);
        }
        $this->date = trim(str_replace("&nbsp;","", $this->_paragraphs[0]));
        $this->description = trim($this->_paragraphs[2]);

        $this->_paragraphs[1] = str_replace("&nbsp;","", $this->_paragraphs[1]);
        
        $this->year = $this->matchInParagraph('/Год:(....)/');
        $this->genre = $this->matchInParagraph('/Жанр:(.*)Страна/');
        $this->country = $this->matchInParagraph('/Страна:(.*)Возраст/');
        $this->age = $this->matchInParagraph('/Возраст:(.*)Режиссер/');
        $this->producer = $this->matchInParagraph('/Режиссер:(.*)Актеры/');
        $this->actors = $this->matchInParagraph('/Актеры:(.*)/');
        unset($this->_paragraphs);
        
    }
    function breakIntoParagraphs() {
        $this->_paragraphs = explode("</p>", $this->_concatText);
        unset($this->_introText);
        unset($this->_fulltext);
        unset($this->_concatText);
    }
    function matchInParagraph($regExp) {
        $status = preg_match($regExp, $this->_paragraphs[1], $matches, PREG_OFFSET_CAPTURE);
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
        $schedule = new SunnySchedule($dataId,'Расписание киносеансов','<p>Уважаемые посетители! Расписание сеансов может меняться, уточняйте информацию по телефону 2-77-82.</p>
<p><span style="color: #ff0000;"><strong>27</strong></span><strong style="color: #ff0000;">&nbsp;июня (четверг)</strong></p>
<p><span style="color: #000080;"><strong>10:00</strong></span> <a href="index.php?option=com_content&amp;view=article&amp;id=285:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-4&amp;catid=20:kinoteatr"><strong>Лови момент</strong></a> 2D, комедия,&nbsp; Россия&nbsp; (150р)</p>
<p><span style="color: #000080;"><strong>12:00</strong></span> <a href="index.php?option=com_content&amp;view=article&amp;id=279:istoriya-igrushek-animatsiya-priklyucheniya-6-3d&amp;catid=20:kinoteatr"><strong>История игрушек 4</strong></a>&nbsp;3D, анимация,&nbsp; США (120р)</p>
<p><span style="color: #000080;"><strong>14:00</strong></span>&nbsp;<a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"><strong>Люди в черном: Интенэшнл</strong></a>&nbsp;3D, фантастика, комедийный экшн, США, 12+ (150р)</p>
<p><span><span style="color: #ff0000;"><strong>с 28</strong></span><strong style="color: #ff0000;">&nbsp;по 29 июня (пятница, суббота)</strong></span></p>
<p><span style="color: #000080;"><strong>10:00</strong></span>&nbsp;<a href="index.php?option=com_content&amp;view=article&amp;id=278:film10-12&amp;catid=20:kinoteatr"><strong>Игра</strong></a> 2D, драма, саспенс, триллер, Россия, 16+ (150р)</p>
<p><span style="color: #000080;"><strong>12:00</strong></span> <a href="index.php?option=com_content&amp;view=article&amp;id=279:istoriya-igrushek-animatsiya-priklyucheniya-6-3d&amp;catid=20:kinoteatr"><strong>История игрушек 4</strong></a>&nbsp;3D, анимация,&nbsp; США (120р)</p>
<p><span style="color: #000080;"><strong>14:00</strong></span>&nbsp;<a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"><strong>Люди в черном: <strong>Интенэшнл</strong></strong></a><strong><a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"></a></strong>&nbsp;3D, фантастика, комедийный экшн, США, 12+ (150р)</p>
<p>&nbsp;<span style="color: #ff0000;"><strong>30 и</strong></span><strong style="color: #ff0000;">юня (воскресенье)</strong></p>
<p><span style="color: #000080;"><strong>10:00</strong></span>&nbsp;<a href="index.php?option=com_content&amp;view=article&amp;id=278:film10-12&amp;catid=20:kinoteatr"><strong>Игра</strong></a> 2D, драма, саспенс, триллер, Россия, 16+ (150р)</p>
<p><span style="color: #000080;"><strong>14:00</strong></span>&nbsp;<a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"><strong>Люди в черном: <strong>Интенэшнл</strong></strong></a><strong><a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"></a></strong>&nbsp;3D, фантастика, комедийный экшн, США, 12+ (150р)</p>
',
'
<p><span><span style="color: #ff0000;"><strong>1</strong></span><strong style="color: #ff0000;">&nbsp;июля (понедельник)</strong></span></p>
<p><span style="color: #000080;"><strong>10:00</strong></span> <a href="index.php?option=com_content&amp;view=article&amp;id=285:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-4&amp;catid=20:kinoteatr"><strong>Лови момент</strong></a> 2D, комедия,&nbsp; Россия&nbsp; (150р)</p>
<p><span style="color: #000080;"><strong>12:00</strong></span> <a href="index.php?option=com_content&amp;view=article&amp;id=279:istoriya-igrushek-animatsiya-priklyucheniya-6-3d&amp;catid=20:kinoteatr"><strong>История игрушек 4</strong></a>&nbsp;3D, анимация,&nbsp; США (120р)</p>
<p><span style="color: #000080;"><strong>14:00</strong></span>&nbsp;<a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"><strong>Люди в черном: <strong>Интенэшнл</strong></strong></a><strong><a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"></a></strong>&nbsp;3D, фантастика, комедийный экшн, США, 12+ (150р)</p>
<p><span><span style="color: #ff0000;"><strong>с 2</strong></span><strong style="color: #ff0000;">&nbsp;по 3 июля (вторник, среда)</strong></span></p>
<p><span style="color: #000080;"><strong>10:00</strong></span>&nbsp;<a href="index.php?option=com_content&amp;view=article&amp;id=278:film10-12&amp;catid=20:kinoteatr"><strong>Игра</strong></a> 2D, драма, саспенс, триллер, Россия, 16+ (150р)</p>
<p><span style="color: #000080;"><strong>12:00</strong></span> <a href="index.php?option=com_content&amp;view=article&amp;id=279:istoriya-igrushek-animatsiya-priklyucheniya-6-3d&amp;catid=20:kinoteatr"><strong>История игрушек 4</strong></a>&nbsp;3D, анимация,&nbsp; США (120р)</p>
<p><span style="color: #000080;"><strong>14:00</strong></span>&nbsp;<a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"><strong>Люди в черном: <strong>Интенэшнл</strong></strong></a><strong><a href="index.php?option=com_content&amp;view=article&amp;id=280:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-2&amp;catid=20:kinoteatr"></a></strong>&nbsp;3D, фантастика, комедийный экшн, США, 12+ (150р)</p>
<p><span style="color: #000080;"><strong>&nbsp;</strong></span></p>
<p>&nbsp;</p>');
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

$response = new SunnyResponse(207);
$response->send();







