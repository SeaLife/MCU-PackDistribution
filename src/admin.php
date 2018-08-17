<?php
/** @noinspection PhpUnhandledExceptionInspection */

use HTTP\RequestHelper;
use HTTP\TemplateLoader;
use HTTP\View;
use MCU\Config;


class AdminInterface {
    public static function init () {
        session_start();

        $interface = new AdminInterface();

        $httpMethod = $_SERVER['REQUEST_METHOD'];

        $interface->doAction(RequestHelper::getPathVariable(2, NULL), $httpMethod);

        return $interface;
    }

    public function doAction ($action, $method = "GET") {
        if (empty($action)) $action = "login"; // set default action


        try {
            $methodName = strtolower($method) . ucfirst($action);

            $values = array();

            if (method_exists($this, $methodName)) {
                $res = $this->$methodName();

                if (is_array($res)) {
                    $values = $res;
                }
            }

            TemplateLoader::render(new View("$action.twig", $values));
        } catch (Exception $e) {
            echo "<pre>";
            echo get_class($e) . "\n\n{$e->getMessage()}\n\n";
            echo $e->getTraceAsString();
            echo "</pre>";
        }
    }

    /**
     * @httpMethod GET
     */
    public function getLogin () {
        if ($_SESSION["STATE_LOGIN"]) {
            header("Location: /index.php/admin/overview");
        }

        return array(
            "attempts" => $_SESSION["__LOGIN_ATTEMPT"]
        );
    }

    /**
     * @httpMethod GET
     */
    public function getLogout () {
        if ($_SESSION["STATE_LOGIN"]) {
            session_destroy();
        }
        header("Location: /index.php/admin/login");
    }

    /**
     * @httpMethod POST
     */
    public function postLogin () {
        $password = $_POST["password"];
        $success  = FALSE;

        if ($password == Config::get("app.password.admin")) {
            $success                     = TRUE;
            $_SESSION["__LOGIN_ATTEMPT"] = 0;
        }

        $_SESSION["STATE_LOGIN"] = $success;

        if (!$success) {
            if (!isset($_SESSION["__LOGIN_ATTEMPT"])) $_SESSION["__LOGIN_ATTEMPT"] = 0;

            $_SESSION["__LOGIN_ATTEMPT"]++;
        }

        if ($_SESSION["__LOGIN_ATTEMPT"] == 4) {
            session_destroy();
            RequestHelper::banCurrentIp();
            header("Location: /index.php");
        }

        return array(
            "loginSuccess" => $success,
            "attempts"     => $_SESSION["__LOGIN_ATTEMPT"]
        );
    }

    /**
     * @httpMethod POST
     */
    public function post () {
        $this->postLogin();
    }
}

AdminInterface::init();