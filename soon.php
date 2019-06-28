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
        $this->title = "\"Норм и несокрушимые: Большое Путешествие\" анимация, Индия, США, 6+, 2D";
        $this->_introText = "<p>&nbsp;<strong><span style=\"font-size: 14pt; color: #ff0000;\">с 4 по 24 июля</span></strong></p>
<p><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Год:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">&nbsp;2019</span><br style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\" /><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Жанр:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\"> анимация</span><br style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\" /><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Страна:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">&nbsp;Индия, США</span><br style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\" /><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Возраст:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">&nbsp;6+<br /><strong>Режиссер</strong>: Тим Болтби, Ричард Финн<br /></span><strong style=\"padding: 0px; margin: 0px; color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">Время:</strong><span style=\"color: #666666; font-family: Tahoma, Georgia, 'Times New Roman', Times, serif; font-size: 13.2px;\">&nbsp;90 мин.&nbsp;</span></p>
<section class=\"release-card-section\">
<p class=\"release-card__description\">В ледяных горах Арктики терпит крушение самолет, управляемый археологом Джином.</p>
";
        $this->_fulltext = "
<p class=\"release-card__description\">Аварию подстроил его коварный напарник, который похищает бесценную нефритовую статуэтку китайского божества – ключ к несметным сокровищам. На помощь Джину приходит король Арктики Норм. В компании с леммингами он отправляется в смертельно опасное путешествие. На этот раз обаятельный и простодушный мишка должен не только обезвредить злодея и вернуть бесценную реликвию, но и успеть на свадьбу своего эксцентричного дедушки…<span style=\"background-color: inherit; color: inherit; font-size: 1rem;\"></span></p>
</section>
<p>{youtube}Aju9ooYTBCw{/youtube}</p>
<p>{gallery}kino/norm:180:180:0:0{/gallery}</p>";
        $this->_concatText =  $this->_introText.$this->_fulltext;
        $this->breakIntoParagraphs();
        $this->images = json_decode("{\"image_intro\":\"images\/kino\/norm\/\u041d\u043e\u0440\u043c\u044b \u0433\u043e\u0440\u0438\u0437\u043e\u043d\u0442.jpeg\",\"float_intro\":\"none\",\"image_intro_alt\":\"\",\"image_intro_caption\":\"\",\"image_fulltext\":\"images\/kino\/norm\/\u041d\u043e\u0440\u043c\u044b \u0433\u043e\u0440\u0438\u0437\u043e\u043d\u0442.jpeg\",\"float_fulltext\":\"none\",\"image_fulltext_alt\":\"\",\"image_fulltext_caption\":\"\"}");
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
        $schedule = new SunnySchedule($dataId,'Скоро в кино','p><span style="color: #ff0000;"><strong>с 4 июля</strong></span></p>
<p><a href="index.php?option=com_content&amp;view=article&amp;id=289:film10-14&amp;catid=20:kinoteatr"><strong>Норм и несокрушимые: Большое Путешествие</strong></a> (анимация, Индия, США, 6+, 2Д)</p>
<p><a href="index.php?option=com_content&amp;view=article&amp;id=297:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-5&amp;catid=20:kinoteatr"><strong>Гости</strong> </a>(ужасы, триллер, мелодрама,&nbsp; Россия, 16+, 2Д)</p>
<p><span style="color: #ff0000;"><strong>с 11 июля</strong></span></p>
<p><strong><a href="index.php?option=com_content&amp;view=article&amp;id=290:film10-15&amp;catid=20:kinoteatr">Беглецы</a>&nbsp;</strong>(комедия, Латвия, Россия, 16+, 2Д)</p>
<p><a href="index.php?option=com_content&amp;view=article&amp;id=298:istoriya-igrushek-animatsiya-priklyucheniya-6-3d-6&amp;catid=20:kinoteatr"><strong>Детки напрокат</strong></a> (комедия, семейный, Россия, 12+, 2Д)</p>
<p><a href="index.php?option=com_content&amp;view=article&amp;id=299:film10-20&amp;catid=20:kinoteatr"><strong>Принцесса и дракон</strong></a> (анимация, фэнтези, Россия, 6+,&nbsp; 2Д)</p>
<p><span style="color: #ff0000;"><strong>с 18 июля</strong></span></p>
<p><a href="index.php?option=com_content&amp;view=article&amp;id=291:film10-16&amp;catid=20:kinoteatr"><strong>Человек-Паук: Вдали от дома</strong></a>&nbsp;(приключенченский ЭКШН,16+, 3Д)</p>
<p><a href="index.php?option=com_content&amp;view=article&amp;id=293:film10-18&amp;catid=20:kinoteatr"><strong>Это не навсегда</strong></a> (драма, Россия, 12+, 2Д)</p>
<p><span style="color: #ff0000;"><strong>с 25 июля</strong></span></p>
<p><a href="index.php?option=com_content&amp;view=article&amp;id=292:film10-17&amp;catid=20:kinoteatr"><strong>Шаг вперед 6: Год танцев</strong></a> (драма, мюзикл, Китай, США, 12+, 2Д)</p>
<p><span style="color: #ff0000;"><strong>с 1 августа</strong></span></p>
<p><a href="index.php?option=com_content&amp;view=article&amp;id=294:film10-19&amp;catid=20:kinoteatr"><strong>Король Лев</strong></a> (приключения, семейный, США, 6+, 3Д)</p>',
'');
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

$response = new SunnyResponse(212);
$response->send();







