<?php

namespace HTTP;

class View {
    private $values;
    private $file;

    public function __construct ($file, $values = array()) {
        $this->values = $values;
        $this->file   = $file;
    }

    public function map ($key, $value) {
        $this->values[$key] = $value;
        return $this;
    }

    /**
     * @param array $values
     */
    public function setValues ($values) {
        $this->values = $values;
    }

    /**
     * @return mixed
     */
    public function getFile () {
        return $this->file;
    }

    /**
     * @return array
     */
    public function getValues () {
        return $this->values;
    }
}