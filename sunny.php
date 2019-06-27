<?php

class SunnySchedule {
        function __construct($id, $title, $introText, $fullText ) {
            $this->id = $id;
            $this->title = $title;
            $this->introText = $introText;
            $this->fullText = $fullText;
            $this->unionText = $introText.$fullText;
            $this->items = array();
    }
    function breakIntoParagraphs() {
        $this->paragraphs = explode("</p>",$this->unionText);
    }
    function textToObject() {
        foreach ($this->paragraphs as $value) {
            $this->items[] = new ScheduleItem($value);
        }
    }
}

class ScheduleItem  {
    function __construct($text) {
        $this->text = $text;
        $this->getId();
    }
    function getId() {
        $pos = strstr($this->text, "id=");
        $ss = substr($this->text, $pos + 3, 5);
        $this->id = $pos;
    }
}

$shedule = new SunnySchedule('207','Расписание киносеансов','<p>Уважаемые посетители! Расписание сеансов может меняться, уточняйте информацию по телефону 2-77-82.</p>
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
$shedule->breakIntoParagraphs();
$shedule->textToObject();
print_r($shedule);
