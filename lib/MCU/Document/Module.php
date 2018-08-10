<?php

namespace MCU\Document;

use XML\XMLNode;

class Module implements XMLNode {
    public $id;
    public $name;
    public $side  = "BOTH";
    public $items = array();

    public function addItem (XMLNode $item) {
        array_push($this->items, $item);
    }

    public function getName () {
        return "Module";
    }

    public function getAttributes () {
        return array(
            "id"   => $this->id,
            "name" => $this->name,
            "side" => $this->side,
        );
    }

    public function getContent () {
        return $this->items;
    }
}