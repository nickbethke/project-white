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
            exit;
        } else {
            echo "\t help \t\t\t\t shows this help" . PHP_EOL . PHP_EOL;
            echo "\t install \t\t\t run installation script" . PHP_EOL . PHP_EOL;
            echo "\t user::create \t\t\t create a default user" . PHP_EOL;
            echo "\t user::create::admin \t\t create an admin user" . PHP_EOL;
            echo "\t user::list \t\t\t lists all active users" . PHP_EOL . PHP_EOL;
            echo "\t mail::send::test \t\t send a test email" . PHP_EOL;
            echo "\t mail::smtp::check \t\t check smtp connection" . PHP_EOL . PHP_EOL;
            echo "\t option::add \t\t\t add an option" . PHP_EOL;
            echo "\t option::update \t\t update an option" . PHP_EOL;
            echo "\t option::update::autoload \t update an option's autoload" . PHP_EOL;
            echo "\t option::delete \t\t delete an option" . PHP_EOL;
            echo "\t\t\t\t\t use '_array_' as option value if option should be empty array" . PHP_EOL . PHP_EOL;
            echo "\t option::list \t\t\t lists all options" . PHP_EOL;
            echo "\t option::list::auto \t\t lists all autoload options" . PHP_EOL;

            echo PHP_EOL;
        }
    }
}