<?php

namespace MCU\Document\Modifier;

use XML\XMLNode;

class ModPath implements XMLNode {

    public $path;

    public function getName () {
        return "ModPath";
    }

    public function getAttributes () {
        return array();
    }

    public function getContent () {
        return $this->path;
    }
}