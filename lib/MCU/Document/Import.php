<?php

namespace MCU\Document;

use XML\XMLNode;

class Import implements XMLNode {
    public $url;
    public $packId;

    public function getName () {
        return "Import";
    }

    public function getAttributes () {
        return array(
            "url" => $this->url
        );
    }

    public function getContent () {
        return $this->packId;
    }
}