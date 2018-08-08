<?php

namespace XML;


class XMLGenerator {
    /**
     * @var XMLConfiguration
     */
    private $config = NULL;

    public function setConfig ($config) {
        $this->config = $config;
    }

    public function render (XMLNode $base) {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";

        if ($this->config != NULL) {
            $xml .= '<?xml-stylesheet href="' . $this->config->getTheme() . '" type="text/xsl" ?>' . "\n";
        }

        $xml .= $this->generateFrom($base);

        return $xml;
    }

    public function generateFrom (XMLNode $root, $intend = 0) {
        $attributesString = "";

        foreach ($root->getAttributes() as $k => $v) {
            if (is_bool($v)) {
                $v = $v ? "true" : "false";
            }

            if (empty($v)) continue;

            $v                = htmlspecialchars($v);
            $attributesString .= " $k=\"$v\"";
        }

        $intendString = $this->getIntend($intend);

        $item = "{$intendString}<{$root->getName()}$attributesString>\n";

        if (is_array($root->getContent())) {
            $item .= $this->generateFromList($root->getContent(), $intend + 1);
        } else {
            $item .= $this->getIntend($intend + 1) . $root->getContent() . "\n";
        }

        $item .= "{$intendString}</{$root->getName()}>";

        return $item;
    }

    public function generateFromList (array $itemList, $intend = 0) {
        $out = "";

        foreach ($itemList as $item) {
            $out .= $this->generateFrom($item, $intend);
            $out .= "\n";
        }

        return $out;
    }

    private function getIntend ($intend) {
        $intends = "";

        for ($i = 0; $i < $intend; $i++) {
            $intends .= "    ";
        }

        return $intends;
    }
}