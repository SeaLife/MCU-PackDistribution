<?php

namespace XML;


class XMLConfiguration {
    private $theme;

    public function getTheme () {
        return $this->theme;
    }

    public function setTheme ($theme) {
        $this->theme = $theme;
    }
}