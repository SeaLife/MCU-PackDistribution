<?php

namespace MCU\Document;

use XML\XMLNode;

class Server implements XMLNode {
    public $id;
    public $name;
    public $newsUrl;
    public $version;
    public $mainClass;
    public $revision;
    public $serverAddress;
    public $abstract;
    public $autoConnect;
    public $items = array();

    public function addItem (XMLNode $item) {
        array_push($this->items, $item);
    }

    public function getName () {
        return "Server";
    }

    public function getAttributes () {
        return array(
            "id"            => $this->id,
            "name"          => $this->name,
            "newsUrl"       => $this->newsUrl,
            "version"       => $this->version,
            "mainClass"     => $this->mainClass,
            "revision"      => $this->revision,
            "serverAddress" => $this->serverAddress,
            "abstract"      => $this->abstract,
            "autoConnect"   => $this->autoConnect
        );
    }

    public function getContent () {
        return $this->items;
    }
}