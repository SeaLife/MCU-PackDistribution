<?php

namespace XML;


/**
 * Class XMLConfiguration
 * @package XML
 */
class XMLConfiguration {
    /** @var string */
    private $theme;

    public function getTheme () {
        return $this->theme;
    }

    public function setTheme ($theme) {
        $this->theme = $theme;
    }
}