<?php

namespace CLI;

use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;

class Help extends Runnable
{

    /**
     * @throws InvalidStyleException
     */
    public static function run(mixed $args): void
    {
        echo self::header();
        if ($args) {

            echo (new ConsoleColor())->apply(Runnable::WARNING, "\t > Action 'help::$args' missing. Use cli.php help\n\n");
        } else {
            echo "\t Help" . PHP_EOL;
            echo "\t\t help \t\t\t shows this help" . PHP_EOL . PHP_EOL;
            echo "\t\t install \t\t run installation script" . PHP_EOL . PHP_EOL;
            echo "\t\t user::create \t\t create a default user" . PHP_EOL;
            echo "\t\t user::create::admin \t create an admin user" . PHP_EOL;
            echo "\t\t user::list \t\t lists all active users" . PHP_EOL . PHP_EOL;
            echo "\t\t mail::send::test \t send a test email" . PHP_EOL;
            echo "\t\t mail::smtp::check \t check smtp connection" . PHP_EOL;
            echo PHP_EOL;
        }
    }
}