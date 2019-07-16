<?php

class FilmContainer {
   function __construct($schedule) {
        foreach($schedule as $day) {
            foreach ($day->items as $item) {
                $this->setItem($item);
            }
        }
        $this->createItems();
    }
    function  setItem($item) {
        $this->{$item->id} = $item;
    }
    function createItems() {
        $items = array();
        foreach ($this as $item) {
            $items[] = new FilmContainerItem($item);
        }
        $this->items = $items;
    }
}

class FilmContainerItem {
    function __construct($item) {
        $this->id = $item->id;
        $this->name = $item->body->title;
        $this->logo = $item->body->images->image_intro;
        $this->big_logo = $item->body->images->image_fulltext;
        $this->genre = $item->body->genre;
        $this->country = $item->body->country;
        $this->director = $item->body->producer;
        $this->starring = $item->body->actors;
        $this->age_limit = $item->body->age;
        $this->description = $item->body->description;
        $this->date = $item->body->date;
        $this->youtube = $item->body->youtubeId;
    }
}