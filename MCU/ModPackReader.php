<?php
/** @noinspection SpellCheckingInspection */

namespace MCU;

use MCU\Document\Import;
use MCU\Document\Modifier\DefaultItem;
use MCU\Document\Modifier\Meta;
use MCU\Document\Modifier\ModType;
use MCU\Document\Modifier\URL;
use MCU\Document\Module;
use MCU\Document\Server;
use MCU\Document\ServerPack;
use XML\XMLConfiguration;
use XML\XMLGenerator;

class ModPackReader {
    private $baseFolder = "";

    private $xml;

    public function __construct ($baseFolder) {
        $this->baseFolder = $baseFolder;

        $this->xml = new ServerPack();

        $this->readPacks();
    }

    public function output () {
        $config = new XMLConfiguration();
        $config->setTheme("ServerPackv3.xsl");

        $generator = new XMLGenerator();
        $generator->setConfig($config);

        return $generator->render($this->xml);
    }

    function endsWith ($haystack, $needle) {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }

    function readZipFileEntry ($zipFileName, $searchEntryName) {
        $zip = zip_open($zipFileName);

        if ($zip) {
            while ($zipEntry = zip_read($zip)) {
                $entryName = zip_entry_name($zipEntry);
                if ($entryName == $searchEntryName) {
                    if (zip_entry_open($zip, $zipEntry, "r")) {
                        $searchFileContents = zip_entry_read($zipEntry, zip_entry_filesize($zipEntry));
                        zip_entry_close($zipEntry);
                        zip_close($zip);
                        return $searchFileContents;
                    }
                }
            }

            zip_close($zip);
        }

        return FALSE;
    }

    function getMD5ofFiles ($folder) {
        $files = @scandir($folder);
        @array_shift($files);
        @array_shift($files);

        $fileArray = array();

        if (empty($files)) return array();

        foreach ($files as $file) {
            if (!is_dir($folder . "/" . $file)) {
                $dname    = substr($file, 0, -4);
                $side     = "BOTH";
                $optional = FALSE;
                if ($this->endsWith($dname, "-client")) {
                    $side = "CLIENT";
                }
                if ($this->endsWith($dname, "-server")) {
                    $side = "SERVER";
                }
                if ($this->endsWith($dname, "-optional")) {
                    $side     = "CLIENT";
                    $optional = TRUE;
                }
                $id = $dname;

                $meta = array();

                if ($this->endsWith($file, ".jar")) {
                    $mcmod = $this->readZipFileEntry("$folder/$file", "mcmod.info");
                    if (!empty($mcmod)) {
                        $fileInfo = json_decode($mcmod, TRUE);

                        if (isset($fileInfo["modList"])) {
                            $fileInfo = $fileInfo["modList"][0];
                        } else {
                            $fileInfo = $fileInfo[0];
                        }

                        $id    = $fileInfo["modid"];
                        $dname = $fileInfo["name"];

                        $meta = $fileInfo;
                    }
                }

                array_push($fileArray, array(
                    "name"     => $file,
                    "meta"     => $meta,
                    "dname"    => $dname,
                    "id"       => $id,
                    "side"     => $side,
                    "optional" => $optional,
                    "md5"      => md5_file("$folder/$file"),
                    "file"     => rawurlencode($file)
                ));
            }
        }

        return $fileArray;
    }

    function readPacks () {
        $files = scandir($this->baseFolder);
        array_shift($files);
        array_shift($files);


        foreach ($files as $file) {
            if (is_dir($this->baseFolder . $file)) {

                $requestedPack = @$_GET["pack"];

                if ((!empty($requestedPack) && $requestedPack == $file) || empty($requestedPack)) {

                    $packInfo = $this->baseFolder . $file . "/modpack.json";

                    if (file_exists($packInfo)) {
                        $metaInfo = json_decode(file_get_contents($packInfo), TRUE);

                        $pack                = new Server();
                        $pack->serverAddress = @$metaInfo["serverAddress"];
                        $pack->autoConnect   = @$metaInfo["autoConnect"];
                        $pack->abstract      = @$metaInfo["abstract"];
                        $pack->revision      = @$metaInfo["version"];
                        $pack->version       = @$metaInfo["mcVersion"];
                        $pack->name          = isset($metaInfo["name"]) ? $metaInfo["name"] : $file;
                        $pack->id            = $file;
                        $pack->newsUrl       = "{$_ENV["BASE_URL"]}/?pack={$file}";
                        $pack->mainClass     = "net.minecraft.launchwrapper.Launch";


                        if (!isset($_GET["import"])) {
                            $forge         = new Import();
                            $forge->url    = "http://files.mcupdater.com/example/forge.php?mc={$metaInfo["mcVersion"]}&forge={$metaInfo["forgeVersion"]}";
                            $forge->packId = "forge";

                            $pack->addItem($forge);
                        }

                        foreach ($metaInfo["imports"] as $import) {
                            $importModule         = new Import();
                            $importModule->url    = "{$_ENV["BASE_URL"]}/?pack={$import}&import=true";
                            $importModule->packId = $import;

                            $pack->addItem($importModule);
                        }

                        $this->xml->addItem($pack);

                        foreach ($this->getMD5ofFiles($this->baseFolder . $file . "/mods") as $mod) {
                            $module       = new Module();
                            $module->id   = $mod["id"];
                            $module->name = $mod["meta"]["name"];
                            $module->side = $mod["side"];

                            $url           = new URL();
                            $url->priority = 0;
                            $url->url      = "{$_ENV["BASE_URL"]}/{$this->baseFolder}{$file}/mods/{$mod["file"]}";

                            if ($mod["optional"]) {
                                $module->addItem(new DefaultItem("Required", "false"));
                            } else {
                                $module->addItem(new DefaultItem("Required", "true"));
                            }

                            $module->addItem($url);

                            $module->addItem(new DefaultItem("MD5", $mod["md5"]));

                            $module->addItem(new DefaultItem("ModType", "Regular"));

                            if (!empty($mod["meta"])) {
                                $m = $mod["meta"];

                                $meta = new Meta();

                                if (!empty($m["description"])) $meta->addItem(new DefaultItem("description", $m["description"]));
                                if (!empty($m["url"])) $meta->addItem(new DefaultItem("url", $m["url"]));
                                if (!empty($m["version"])) $meta->addItem(new DefaultItem("version", $m["version"]));
                                if (!empty($m["authors"])) $meta->addItem(new DefaultItem("authors", join(",", $m["authors"])));

                                $module->addItem($meta);
                            }

                            $pack->addItem($module);
                        }

                        if (!isset($_GET["import"])) {
                            $forgeMod       = new Module();
                            $forgeMod->name = "Minecraft Forge";
                            $forgeMod->id   = "forge-{$metaInfo["forgeVersion"]}";

                            $forgeMod->addItem(new DefaultItem("Size", "100000"));
                            $forgeMod->addItem(new DefaultItem("Required", "true"));

                            $forgeType        = new ModType();
                            $forgeType->order = 1;
                            $forgeType->type  = "Override";

                            $forgeMod->addItem($forgeType);

                            $pack->addItem($forgeMod);
                        }
                    }
                }
            }
        }
    }
}