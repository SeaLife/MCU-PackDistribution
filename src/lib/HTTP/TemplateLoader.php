<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace HTTP;


use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

class TemplateLoader {

    /** @var LoaderInterface */
    private static $loader;
    /** @var Environment */
    private static $env;

    private static function init () {
        if (!isset(self::$loader)) {
            self::$loader = new FilesystemLoader(realpath(__DIR__ . "/../../templates"));
        }

        if (!isset(self::$env)) {
            self::$env = new Environment(self::$loader, array(
                "cache" => false
            ));

            self::$env->addExtension(new DebugExtension());
        }
    }

    /**
     * Loads the template and returns the content (parsed)
     * @param       $fileName
     * @param array $values
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public static function load ($fileName, $values = array()) {
        self::init();

        return self::$env->render($fileName, $values);
    }

    /**
     * Renders a Template to the web output.
     *
     * @param View $tpl
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public static function render (View $tpl) {
        echo self::load($tpl->getFile(), $tpl->getValues());
    }
}