<?php

namespace CLI;

use DatabaseLoader;
use Options;
use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor as ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;

abstract class Runnable
{
    const INFO = 'color_10';
    // --Commented out by Inspection (23.09.2022 02:47):const DEFAULT = 'color_15';
    const WARNING = 'color_220';
    const ALERT = 'color_9';
    const TODO = 'color_14';

    abstract public static function run(mixed $args): void;

    public static function prompt($msg): bool
    {
        echo $msg . " (N)o|(y)es: ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        return trim($line) == 'yes' || trim($line) == 'y' || trim($line) == 'Y' || trim($line) == 'Yes';

    }

    public static function input($msg): string
    {
        echo $msg . ": ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        return trim($line);

    }

    /**
     * @throws InvalidStyleException
     */
    public static function input_select(string $msg, string $indent = "", string ...$options): string
    {
        echo $msg . PHP_EOL;

        $i = 0;
        foreach ($options as $o) {
            echo $indent . (new ConsoleColor())->apply(self::WARNING, $i) . " " . $o . PHP_EOL;

            $i++;
        }

        $i = sizeof($options) - 1;

        echo $indent . "Select (0-" . $i . "): ";

        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        if (intval(trim($line)) > 0 && intval(trim($line)) <= $i) {
            return $options[intval(trim($line))];
        } else {
            return self::input_select($msg, $indent, ...$options);
        }
    }

    public static function header($html = false): string
    {
        if ($html) {
            return "<div style='font-family: monospace'><br/>██████╗&nbsp;██████╗&nbsp;&nbsp;██████╗&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██╗███████╗&nbsp;██████╗████████╗&nbsp;&nbsp;&nbsp;&nbsp;██╗&nbsp;&nbsp;&nbsp;&nbsp;██╗██╗&nbsp;&nbsp;██╗██╗████████╗███████╗
<br/>██╔══██╗██╔══██╗██╔═══██╗&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║██╔════╝██╔════╝╚══██╔══╝&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;██║██║&nbsp;&nbsp;██║██║╚══██╔══╝██╔════╝
<br/>██████╔╝██████╔╝██║&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║█████╗&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;█╗&nbsp;██║███████║██║&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;█████╗&nbsp;&nbsp;
<br/>██╔═══╝&nbsp;██╔══██╗██║&nbsp;&nbsp;&nbsp;██║██&nbsp;&nbsp;&nbsp;██║██╔══╝&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║███╗██║██╔══██║██║&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;██╔══╝&nbsp;&nbsp;
<br/>██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;██║╚██████╔╝╚█████╔╝███████╗╚██████╗&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;╚███╔███╔╝██║&nbsp;&nbsp;██║██║&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;███████╗
<br/>╚═╝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;╚═╝&nbsp;&nbsp;╚═╝&nbsp;╚═════╝&nbsp;&nbsp;╚════╝&nbsp;╚══════╝&nbsp;╚═════╝&nbsp;&nbsp;&nbsp;╚═╝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;╚══╝╚══╝&nbsp;╚═╝&nbsp;&nbsp;╚═╝╚═╝&nbsp;&nbsp;&nbsp;╚═╝&nbsp;&nbsp;&nbsp;╚══════╝</div><br/><br/>";
        } else {
            return "\n\t██████╗ ██████╗  ██████╗      ██╗███████╗ ██████╗████████╗    ██╗    ██╗██╗  ██╗██╗████████╗███████╗
\t██╔══██╗██╔══██╗██╔═══██╗     ██║██╔════╝██╔════╝╚══██╔══╝    ██║    ██║██║  ██║██║╚══██╔══╝██╔════╝
\t██████╔╝██████╔╝██║   ██║     ██║█████╗  ██║        ██║       ██║ █╗ ██║███████║██║   ██║   █████╗  
\t██╔═══╝ ██╔══██╗██║   ██║██   ██║██╔══╝  ██║        ██║       ██║███╗██║██╔══██║██║   ██║   ██╔══╝  
\t██║     ██║  ██║╚██████╔╝╚█████╔╝███████╗╚██████╗   ██║       ╚███╔███╔╝██║  ██║██║   ██║   ███████╗
\t╚═╝     ╚═╝  ╚═╝ ╚═════╝  ╚════╝ ╚══════╝ ╚═════╝   ╚═╝        ╚══╝╚══╝ ╚═╝  ╚═╝╚═╝   ╚═╝   ╚══════╝\n\n";
        }
    }

    /**
     * @throws InvalidStyleException
     */
    public function create_option($name, $value, $autoload = false): void
    {
        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        require_once ABSPATH . "components/classes/Options.php";
        global $db;
        $db = DatabaseLoader::call();
        $color = new ConsoleColor();
        echo "\t\t\t Create option '" . $name . "' with value: " . $value . PHP_EOL;
        if (Options::option_exists($name)) {
            if (self::prompt($color->apply(self::WARNING, "\t\t\t\t ! Option already exists - override?"))) {
                Options::update_option($name, $value, $autoload);
                echo $color->apply(self::WARNING, "\t\t\t\t > Option updated" . PHP_EOL);
            } else {
                echo $color->apply(self::WARNING, "\t\t\t\t > Option not created" . PHP_EOL);
            }
        } else {
            Options::set_option($name, $value, $autoload);
            echo $color->apply(self::INFO, "\t\t\t\t > Option '" . $name . "' created" . PHP_EOL);
        }
    }
}