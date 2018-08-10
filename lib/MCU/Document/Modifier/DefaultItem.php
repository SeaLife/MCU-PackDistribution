<?php

namespace MCU\Document\Modifier;

use XML\XMLNode;

class DefaultItem implements XMLNode {

    private $name;
    private $content;

    public function __construct ($name, $content) {
        $this->name    = $name;
        $this->content = $content;
    }

    public function getName () {
        return $this->name;
    }

    public function getAttributes () {
        return array();
    }

    public function getContent () {
        return $this->content;
    }
}