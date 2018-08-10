<?php

namespace MCU\Document;

use XML\XMLNode;

class ServerPack implements XMLNode {
    public $version        = "3.3";
    public $xmlns          = "http://www.mcupdater.com";
    public $xmlns_xsi      = "http://www.w3.org/2001/XMLSchema-instance";
    public $schemaLocation = "http://www.mcupdater.com http://files.mcupdater.com/ServerPackv2.xsd";
    public $items          = array();

    public function addItem (XMLNode $item) {
        array_push($this->items, $item);
    }

    public function getName () {
        return "ServerPack";
    }

    public function getAttributes () {
        return array(
            "version"            => $this->version,
            "xmlns"              => $this->xmlns,
            "xmlns:xsi"          => $this->xmlns_xsi,
            "xsi:schemaLocation" => $this->schemaLocation
        );
    }

    public function getContent () {
        return $this->items;
    }
}