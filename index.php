<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/


$packUrl      = "https://mc.r3ktm8.de";
$mcVersion    = "1.12.2";
$forgeVersion = "14.23.4.2747";

$pack = @$_GET["pack"];
$import = @$_GET["import"];

if(empty($import)) { $import = false; }

header("Content-Type: application/xml");

function endsWith($haystack, $needle) {
    $length = strlen($needle);

    return $length === 0 || 
    (substr($haystack, -$length) === $needle);
}

function readZipFileEntry($zipFileName, $searchEntryName) {
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

    return false;
}

function getMD5ofFiles($folder) {
    $files = scandir($folder);
    array_shift($files);
    array_shift($files);

    $fileArray = array();

    foreach ($files as $file) {
        if (is_dir($folder . "/" . $file)) {
            #array_push($fileArray, array(
            #    "name" => $file,
            #    "sub-files" => getMD5ofFiles($folder . "/" . $file)
            #));
        } else {
            $dname = substr($file, 0, -4);
            $side = "BOTH";
            $optional = false;
            if (endsWith ($dname, "-client")) {
                $side = "CLIENT";
            }
            if (endsWith ($dname, "-server")) {
                $side = "SERVER";
            }
            if (endsWith ($dname, "-optional")) {
                $side = "CLIENT";
                $optional = true;
            }
            $id=$dname;

            $meta = array();

            $mcmod = readZipFileEntry("$folder/$file", "mcmod.info");
            if(!empty($mcmod)) {
                $fileInfo = json_decode($mcmod, true);

		if(isset($fileInfo["modList"])) { $fileInfo = $fileInfo["modList"][0]; } else { $fileInfo = $fileInfo[0]; }

                $id = $fileInfo["modid"];
                $dname = $fileInfo["name"];

                $meta = $fileInfo;
            }

            array_push($fileArray, array(
                "name" => $file,
                "meta" => $meta,
                "dname" => $dname,
                "id" => $id,
                "side" => $side,
                "optional" => $optional,
                "md5" => md5_file("$folder/$file"),
                "file" => rawurlencode($file)
            ));
        }
    }

    return $fileArray;
}

function readPacks() {
    $files = scandir(".");
    array_shift($files);
    array_shift($files);

    global $pack;

    $packs = array();

    foreach ($files as $file) {
        if (is_dir ($file)) {
            $meta = array();
            if(file_exists($file."/modpack.json")) {
                if((!empty($pack) && $pack == $file) || empty($pack)) {
                    $meta = json_decode(file_get_contents($file."/modpack.json"), true);
                    array_push($packs, array(
                        "meta" => $meta,
                        "name" => $file,
                        "mods" => getMD5ofFiles($file . "/mods")
                    ));
                }
            }
        }
    }

    return $packs;
}

$modpacks = readPacks();

if($import) {
	include "xml-import-template.php";
} else {
	include "xml-template.php";
}
