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
        global $db;
        $cmdColor = new ConsoleColor();
        print("\033[2J\033[;H");
        echo $cmdColor->apply(self::INFO, "\n\tInstalling project white" . PHP_EOL);
        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;
        echo "\t > CREATE DATABASE TABLES\n";
        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;

        self::create_db(new DataBaseUser(), 'Users');
        self::create_db(new DataBaseOptions(), 'Options');
        self::create_db(new DataBaseNotifications(), 'Notifications');

        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;
        echo "\t > FILLING DATABASE TABLES\n";
        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;

        echo "\t\t > Create Default Options" . PHP_EOL;

        self::create_option('char_set', 'utf-8', true);
        self::create_option('lang_code', 'en', true);
        self::create_option('title', 'Project White', true);

        $home_url = self::input($cmdColor->apply(self::TODO, "\t\t\t Home URL"));
        self::create_option('home_url', $home_url, true);

        $admin_id = self::create_admin();

        echo "\t\t > Create welcome notification" . PHP_EOL;

        require_once ABSPATH . "components/loader/NotificationLoader.php";

        NotificationLoader::include();

        Notification::create("Welcome to Project White", $admin_id, $admin_id, "");

        unlink(ABSPATH . "installing.php");

        echo $cmdColor->apply(self::INFO, "\n\tProject White installed" . PHP_EOL . "\tvisit " . $home_url . " and login with your user information.");
    }

    /**
     * @throws InvalidStyleException
     */
    public static function create_option($name, $value, $autoload = false): void
    {
        global $optionCache;
        $cmdColor = new ConsoleColor();
        echo "\t\t\t Create option '" . $name . "' with value: " . $value . PHP_EOL;
        if (Options::option_exists($name)) {
            if (self::prompt($cmdColor->apply(self::WARNING, "\t\t\t\t ! Option already exists - override?"))) {
                Options::update_option($name, $value, $autoload);
                echo $cmdColor->apply(self::WARNING, "\t\t\t\t > Option updated" . PHP_EOL);
            } else {
                echo $cmdColor->apply(self::WARNING, "\t\t\t\t > Option not created" . PHP_EOL);
            }
        } else {
            Options::set_option($name, $value, $autoload);
            echo $cmdColor->apply(self::INFO, "\t\t\t\t > Option '" . $name . "' created" . PHP_EOL);
        }
    }

    /**
     * @throws InvalidStyleException
     */
    public static function create_admin(): int
    {
        echo "\t\t > Create Admin" . PHP_EOL;
        $cmdColor = new ConsoleColor();
        $firstname = self::input($cmdColor->apply(self::TODO, "\t\t\tFirstname"));
        $surname = self::input($cmdColor->apply(self::TODO, "\t\t\tSurname"));
        $email = self::input($cmdColor->apply(self::TODO, "\t\t\tEmail"));
        $password = self::input($cmdColor->apply(self::TODO, "\t\t\tPassword"));
        $password_repeat = self::input($cmdColor->apply(self::TODO, "\t\t\tPassword repeat"));
        $nickname = self::input($cmdColor->apply(self::TODO, "\t\t\tNickname"));

        if ($firstname && $surname && $email && $password && $password_repeat && $nickname) {

            if ($password == $password_repeat) {
                if ($user = User::create_user($nickname, $password, $firstname, $surname, $email, false, User::STATUS_ADMIN)) {
                    return $user->getId();
                    echo $cmdColor->apply(self::INFO, "\t\t\t > Admin has been created" . PHP_EOL);
                } else {
                    echo $cmdColor->apply(self::WARNING, "\t\t\t ! A user with the same email or nickname already exists" . PHP_EOL);
                    return self::create_admin();
                }

            } else {
                echo $cmdColor->apply(self::WARNING, "\t\t\t ! Password does not match" . PHP_EOL);
                return self::create_admin();
            }
        } else {
            echo $cmdColor->apply(self::WARNING, "\t\t\t ! Information missing - retry" . PHP_EOL);
            return self::create_admin();
        }
    }

    /**
     * @throws InvalidStyleException
     */
    public static function create_user(): int
    {
        require_once ABSPATH . "functions.php";
        echo "\t\t > Create User" . PHP_EOL;
        $cmdColor = new ConsoleColor();
        $firstname = self::input($cmdColor->apply(self::TODO, "\t\t\tFirstname"));
        $surname = self::input($cmdColor->apply(self::TODO, "\t\t\tSurname"));
        $email = self::input($cmdColor->apply(self::TODO, "\t\t\tEmail"));
        $password = self::input($cmdColor->apply(self::TODO, "\t\t\tPassword"));
        $password_repeat = self::input($cmdColor->apply(self::TODO, "\t\t\tPassword repeat"));
        $nickname = self::input($cmdColor->apply(self::TODO, "\t\t\tNickname"));

        if ($firstname && $surname && $email && $password && $password_repeat && $nickname) {

            if ($password == $password_repeat) {
                if ($user = User::create_user($nickname, $password, $firstname, $surname, $email, true, User::STATUS_USER)) {
                    mail($email, "Project White - User Activation", "A user has been created for you.<br> <a href='" . get_option('home_url') . "/activate.php?key=" . $user->getActivationKey() . "&email=" . $email . "'>Activate</a>");
                    return $user->getId();
                    echo $cmdColor->apply(self::INFO, "\t\t\t > User has been created" . PHP_EOL);
                } else {
                    echo $cmdColor->apply(self::WARNING, "\t\t\t ! A user with the same email or nickname already exists" . PHP_EOL);
                    return self::create_user();
                }

            } else {
                echo $cmdColor->apply(self::WARNING, "\t\t\t ! Password does not match" . PHP_EOL);
                return self::create_user();
            }
        } else {
            echo $cmdColor->apply(self::WARNING, "\t\t\t ! Information missing - retry" . PHP_EOL);
            return self::create_user();
        }
    }

    /**
     * @throws InvalidStyleException
     */
    public static function create_db($class, $name): void
    {
        $cmdColor = new ConsoleColor();
        global $db;
        echo "\t\t > " . $name . " - " . $class->get_table_name() . PHP_EOL;
        $success = true;
        try {
            $r = $db->query($class->get_create_SQL());
        } catch (mysqli_sql_exception $e) {
            $success = false;
            echo $cmdColor->apply(self::WARNING, "\t\t\t ! Table already exists" . PHP_EOL);
            if (self::prompt("\t\t\t Purge and create?")) {
                $db->query("DROP TABLE " . $class->get_table_name());
                echo $cmdColor->apply(self::INFO, "\t\t\t Table purged" . PHP_EOL);
                $db->query($class->get_create_SQL());
                echo $cmdColor->apply(self::INFO, "\t\t\t Table created" . PHP_EOL);

            } else {
                echo $cmdColor->apply(self::INFO, "\t\t\t Table not created - exists" . PHP_EOL);
            }
        }
        if ($success) {
            echo $cmdColor->apply(self::INFO, "\t\t\t Table created" . PHP_EOL);
        }
    }

    public static function help($args)
    {

    }

    public static function useradd($args)
    {

    }

    public static function run()
    {
        global $argv;
        if (sizeof($argv) > 1) {
            $args = array_slice($argv, 1);
            $action = $args[0];
            $action_args = [];

            if (sizeof($args) > 1) {
                $action_args = array_slice($args, 1);
            }
            if (method_exists("CMD", $action)) {
                CMD::$action($action_args);
            } else {
                $o = new CMDOutput();
                $o->add("");
                $o->accent();
                $o->add("project white CLI - PWCLI");
                $o->add("");
                $o->addLine();
                $o->add("ERROR: missing action '$action'");
                $o->addLine();
                $o->add('Use bin/cmd.php help');
                $o->output();
            }

        } else {
            $o = new CMDOutput();
            $o->add("");
            $o->accent();
            $o->add("project white CLI - PWCLI");
            $o->add("");
            $o->addLine();
            $o->add("ERROR: missing action");
            $o->addLine();
            $o->add('Use bin/cmd.php help');
            $o->output();

        }

    }

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

    private static function check_composer()
    {
        $out = shell_exec("composer about");
        if (str_starts_with($out, "Composer - Dependency Manager for PHP")) {
            return true;
        } else {
            return false;
        }
    }
}

class CMDOutput
{
    private int $maxLength = 0;
    private array $lines = [];

    public function addLine(): void
    {
        $this->lines[] = "%-%";
    }

    public function accent(): void
    {
        $this->lines[] = "%a%";
    }

    public function add($line): void
    {
        $l = strlen($line);
        $l > $this->maxLength ? $this->maxLength = $l : false;
        $this->lines[] = $line;
    }

    public function output(): void
    {
        $string = "\t╔" . str_repeat("═", $this->maxLength + 2) . "\e[0m╗\n";

        $prev_action = false;
        foreach ($this->lines as $item) {
            if ($item === "%a%") {
                $string .= "\t║ \e[96m";
                $prev_action = true;
            } else if ($item === "%-%") {
                if ($prev_action) {
                    $string .= "\e[0m";
                }
                $string .= "\t╠ " . str_repeat("═", $this->maxLength) . " \e[0m╣\n";
                $prev_action = false;
            } else {
                $l = strlen($item);
                $r = $this->maxLength - $l;
                if ($prev_action) {
                    $string .= $item . str_repeat(" ", $r) . " \e[0m║\n";
                } else {
                    $string .= "\t║ " . $item . str_repeat(" ", $r) . " \e[0m║\n";
                }
                $prev_action = false;
            }
        }

        $string .= "\t╚" . str_repeat("═", $this->maxLength + 2) . "╝\n";

        echo $string;
    }
}