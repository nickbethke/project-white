<?php /** @noinspection PhpUnused */
/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor as ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;

class CMD
{
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

    /**
     * @throws InvalidStyleException
     */
    public static function user($args): void
    {
        require_once ABSPATH . "components/classes/cli/User.php";
        CLI\User::run($args);
    }

    public static function mail($args): void
    {
        require_once ABSPATH . "components/classes/cli/Mail.php";
        CLI\Mail::run($args);
    }

    /**
     * @throws InvalidStyleException
     */
    public static function run(): void
    {
        global $argv;

        print("\033[2J\033[;H");

        if (sizeof($argv) > 1) {
            $args = array_slice($argv, 1);
            $action = explode("::", $args[0])[0];
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

                echo (new ConsoleColor())->apply(CLI\Runnable::WARNING, "\t > Action '$action' missing. Use cli.php help\n\n");
            }

        } else {
            require_once ABSPATH . "components/classes/cli/NoAction.php";
            CLI\NoAction::run([]);
        }

    }
}