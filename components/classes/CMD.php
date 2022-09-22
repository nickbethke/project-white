<?php

use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor as ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;

class CMD
{
    // https://user-images.githubusercontent.com/89590/40762008-687f909a-646c-11e8-88d6-e268a064be4c.png
    const INFO = 'color_10';
    const DEFAULT = 'color_15';
    const WARNING = 'color_220';
    const TODO = 'color_14';


    /**
     * @throws InvalidStyleException
     */
    public static function install($args): void
    {
        require_once ABSPATH . "components/classes/cli/Install.php";
        CLI\Install::run($args);
    }


    /**
     * @throws InvalidStyleException
     */


    public static function help($args): void
    {
        require_once ABSPATH . "components/classes/cli/Help.php";
        CLI\Help::run($args);
    }

    public static function user($args): void
    {
        require_once ABSPATH . "components/classes/cli/User.php";
        CLI\User::run($args);
    }

    /**
     * @throws InvalidStyleException
     */
    public static function run(): void
    {
        global $argv;

        if (sizeof($argv) > 1) {
            $args = array_slice($argv, 1);
            $action = explode("::", $args[0])[0];
            $action_args = [];

            if (sizeof($args) > 1) {
                $action_args = $args;
                $action_args[0] = join("::", array_slice(explode("::", $args[0]), 1));
            } else {
                $action_args = join("::", array_slice(explode("::", $args[0]), 1));
            }
            if (method_exists("CMD", $action)) {
                CMD::$action($action_args);
            } else {
                echo CLI\Runnable::header();

                echo (new ConsoleColor())->apply(\CLI\Runnable::WARNING, "\t > Action '$action' missing. Use cli.php help\n\n");
            }

        } else {
            require_once ABSPATH . "components/classes/cli/NoAction.php";
            CLI\NoAction::run([]);
        }

    }
}