<?php
/** @noinspection PhpIncludeInspection */

use PhpParser\PrettyPrinter\Standard;
use Plumbok\Compiler;
use Plumbok\Compiler\NodeFinder;
use Plumbok\TagsUpdater;

set_exception_handler(function (Throwable $ex) {
    echo "<pre>";
    echo $ex->getMessage();
    echo "\n";
    echo "\n";
    echo $ex->getTraceAsString();
    echo "</pre>";
});

spl_autoload_register(function ($name) {
    if (!class_exists($name)) {
        $classFile = str_replace("\\", "/", $name);
        $file      = "lib/$classFile.php";
        $pbFile    = "lib/plumbok-cache/" . str_replace("/", "_", $classFile) . ".php";

        $cacheEnabled = orv($_ENV["INTERNAL_PLUMBOK_CACHE"], TRUE);
        $update       = orv($_ENV["INTERNAL_PLUMBOK_UPDATE_ORIGINAL"], FALSE);

        if (file_exists($pbFile) && $cacheEnabled) {
            include_once $pbFile;
        } else {
            if (file_exists($file)) {

                try {
                    $plumbokCompiler = new Compiler();
                    $nodes           = $plumbokCompiler->compile($file);
                    $serialize       = new Standard();

                    if ($update) {
                        try {
                            $tagsUpdater = new TagsUpdater(new NodeFinder());
                            $tagsUpdater->applyNodes($file, ...$nodes);
                        } catch (\Throwable $e) {
                            echo $e->getTraceAsString();
                        }
                    }

                    $fileContent = $serialize->prettyPrint($nodes);


                    if (!empty(trim($fileContent))) {
                        file_put_contents($pbFile, "<?php \n\n" . $fileContent);

                        include_once $pbFile;

                        if (!$cacheEnabled) {
                            @unlink($pbFile);
                        }
                    } else {
                        throw new InvalidArgumentException("Plumbok is empty ...");
                    }
                } catch (Throwable $e) {
                    include_once $file;
                }
            }
        }
    }
});

include_once (isset($_ENV["COMPOSER_LOCATION"]) ? $_ENV["COMPOSER_LOCATION"] : "../") . "vendor/autoload.php";

function orv ($val, $or) {
    if (!isset($val) || empty($val)) {
        return $or;
    }

    if (strtolower($val) == "off") return FALSE;
    if (strtolower($val) == "on") return TRUE;

    return $val;
}

include "config.php";
include "app.php";