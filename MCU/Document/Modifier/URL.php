<?php

namespace MCU\Document\Modifier;

use XML\XMLNode;

class URL implements XMLNode {

    public $priority = 0;
    public $url;

    public function getName () {
        return "URL";
    }

    public function getAttributes () {
        return array(
            "priority" => $this->priority
        );
    }

    public function getContent () {
        return $this->url;
    }
}