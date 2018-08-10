<?php

namespace MCU\Document\Modifier;

use XML\XMLNode;

class ModType implements XMLNode {
    public $order;
    public $launchArgs;
    public $type;

    public function getName () {
        return "ModType";
    }

    public function getAttributes () {
        return array(
            "order"      => $this->order,
            "launchArgs" => $this->launchArgs
        );
    }

    public function getContent () {
        return $this->type;
    }
}