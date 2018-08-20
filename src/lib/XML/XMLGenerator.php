<?php

namespace XML;

use Plumbok\Annotation\Data;

/**
 * Class XMLGenerator
 *
 * @package XML
 * @Data
 * @method void __construct()
 * @method \XML\XMLConfiguration getConfig()
 * @method void setConfig(\XML\XMLConfiguration $config)
 */
class XMLGenerator {
    /**
     * @var XMLConfiguration
     */
    private $config = NULL;

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

            if (!is_numeric($v) && empty($v)) continue;

            $v                = htmlspecialchars($v);
            $attributesString .= " $k=\"$v\"";
        }

        $intendString = $this->getIntend($intend);

        $item = "{$intendString}<{$root->getName()}$attributesString>";

        if (is_array($root->getContent())) {
            $item .= "\n";
            $item .= $this->generateFromList($root->getContent(), $intend + 1);
            $item .= "{$intendString}</{$root->getName()}>";
        } else {
            $item .= htmlspecialchars($root->getContent());
            $item .= "</{$root->getName()}>";
        }


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