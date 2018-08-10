<?php

namespace MCU\Document\Modifier;

use XML\XMLNode;

class Meta implements XMLNode {
    private $items = array();

    public function addItem (XMLNode $item) {
        array_push($this->items, $item);
    }

    public function getName () {
        return "Meta";
    }

    public function getAttributes () {
        return array();
    }

    public function getContent () {
        return $this->items;
    }
}