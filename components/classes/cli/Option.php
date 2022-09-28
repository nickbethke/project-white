<?php

namespace CLI;

use DatabaseLoader;
use InitPHP\CLITable\Table;
use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;
use TypesLoader;

class Option extends Runnable
{

    private ConsoleColor $color;

    /**
     * @throws InvalidStyleException
     */
    public static function run(mixed $args): void
    {
        echo self::header();
        new Option($args);
    }

    /**
     * @throws InvalidStyleException
     */
    public function __construct(mixed $args)
    {
        $this->color = new ConsoleColor();
        $action = is_array($args) ? $args[0] : $args;

        switch ($action) {
            case "add":
                $this->add();
                break;
            case "update":
                $this->update();
                break;
            case "update::autoload":
                $this->update_autoload();
                break;
            case "delete":
                $this->delete();
                break;
            case "list":
                $this->list();
                break;
            case "list::auto":
                $this->list(true);
                break;
            case "help":
                $this->help();
                break;
            default:
                echo (new ConsoleColor())->apply(Runnable::WARNING, "\t > Action '$action' missing. Use cli.php help\n\n");
                break;
        }
    }

    /**
     * @throws InvalidStyleException
     */
    private function list($auto_only = false)
    {
        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        require_once ABSPATH . "components/loader/TypesLoader.php";
        require_once ABSPATH . "components/loader/OptionsLoader.php";
        global $db;
        $db = DatabaseLoader::call();
        \OptionsLoader::call();
        TypesLoader::call();

        echo $this->color->apply(self::INFO, "\tListing all options" . PHP_EOL);

        $options = \Options::get_all_options();

        $table = new Table();
        foreach ($options as $option) {
            if ($auto_only && $option['autoload'] != "1") {
                continue;
            }
            $table->row([
                'ID' => $option['id'],
                'name' => $option['name'],
                'value' => $option['value'],
                'autoload' => $option['autoload']
            ]);
        }
        echo "\t" . join("\n\t", explode("\n", $table));
    }

    private function add()
    {
        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        require_once ABSPATH . "components/loader/TypesLoader.php";
        require_once ABSPATH . "components/loader/OptionsLoader.php";
        global $db;
        $db = DatabaseLoader::call();
        \OptionsLoader::call();
        TypesLoader::call();
        require_once ABSPATH . "functions.php";

        echo "\tAdding an option" . PHP_EOL;
        $option_name = self::input($this->color->apply(self::TODO, "\t\tOption name"));

        if ($option_name = preg_replace('/[^a-z _]/i', '', str_replace(" ", "_", preg_replace('/\s+/', ' ', strtolower($option_name))))) {
            if (\Options::option_exists($option_name)) {
                echo $this->color->apply(self::ALERT, PHP_EOL . "\t\t! Option with name '" . $option_name . "' already exists" . PHP_EOL . PHP_EOL);
                exit;
            }
            $option_value = self::input($this->color->apply(self::TODO, "\t\tOption value"));
            if ($option_value == "_array_") {
                $option_value = array();
            }
            $autoload = (self::prompt("\t\tAutoload") ? 1 : 0);

            if (\Options::set_option($option_name, $option_value, boolval($autoload))) {
                echo $this->color->apply(self::INFO, PHP_EOL . "\t\tNew Option Name: '" . $option_name . "'" . PHP_EOL . "\t\tOption value: '" . (is_array($option_value) ? "Array" : $option_value) . "'" . PHP_EOL . "\t\tautoload: " . $autoload . PHP_EOL . PHP_EOL);
                exit;
            } else {
                echo $this->color->apply(self::ALERT, PHP_EOL . "\t\t! Option with name '" . $option_name . "' could not be created" . PHP_EOL . PHP_EOL);
                exit;
            }
        } else {
            echo $this->color->apply(self::ALERT, PHP_EOL . "\t\t! Invalid option name" . PHP_EOL . PHP_EOL);
            exit;
        }

    }

    private function help()
    {
        echo "\t option::add \t\t\t add an option" . PHP_EOL;
        echo "\t option::update \t\t update an option" . PHP_EOL;
        echo "\t option::update::autoload \t update an option's autoload" . PHP_EOL;
        echo "\t option::delete \t\t delete an option" . PHP_EOL;
        echo "\t\t\t\t\t use '_array_' as option value if option should be empty array" . PHP_EOL . PHP_EOL;
        echo "\t option::list \t\t\t lists all options" . PHP_EOL;
        echo "\t option::list::auto \t\t lists all autoload options" . PHP_EOL . PHP_EOL;
    }

    private function delete()
    {
        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        require_once ABSPATH . "components/loader/TypesLoader.php";
        require_once ABSPATH . "components/loader/OptionsLoader.php";
        global $db;
        $db = DatabaseLoader::call();
        \OptionsLoader::call();
        TypesLoader::call();

        echo "\tDelete an option" . PHP_EOL;
        $option_name = self::input($this->color->apply(self::TODO, "\t\tOption name"));
        if (\Options::option_exists($option_name)) {
            \Options::delete_option($option_name);
            echo $this->color->apply(self::INFO, PHP_EOL . "\t\tOption deleted" . PHP_EOL);
        } else {
            echo $this->color->apply(self::WARNING, PHP_EOL . "\t\t! Option does not exists" . PHP_EOL);
        }
        exit;
    }
}