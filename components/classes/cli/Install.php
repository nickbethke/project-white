<?php

namespace CLI;

use JetBrains\PhpStorm\NoReturn;
use \PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor as ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;

class Install extends Runnable
{
    private ConsoleColor $color;
    private $db;

    /**
     * @throws InvalidStyleException
     */
    #[NoReturn] public function __construct($args)
    {
        if ($args) {
            echo Runnable::header();
            echo (new ConsoleColor())->apply(Runnable::WARNING, "\t > Action 'install::$args' missing. Use cli.php help\n\n");
            die();
        }
        $this->color = new ConsoleColor();

        print("\033[2J\033[;H");

        echo $this->color->apply(self::INFO, "\n\tInstalling project white" . PHP_EOL);

        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;
        echo "\t > CREATE CONFIGURATIONS\n";
        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;

        // TODO Database config

        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";

        global $db;
        $db = $this->db_config();

        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;
        echo "\t > CREATE DATABASE TABLES\n";
        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;

        $this->create_db(new \DataBaseUser(), 'Users');
        $this->create_db(new \DataBaseOptions(), 'Options');
        $this->create_db(new \DataBaseNotifications(), 'Notifications');


        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;
        echo "\t > FILLING DATABASE TABLES\n";
        echo "\t══════════════════════════════════════════════════════════════════" . PHP_EOL;

        echo "\t\t > Create Default Options" . PHP_EOL;

        require_once ABSPATH . "components/classes/Options.php";

        $this->create_option('char_set', 'utf-8', true);
        $this->create_option('lang_code', 'en', true);
        $this->create_option('title', 'Project White', true);

        $home_url = self::input($this->color->apply(self::TODO, "\t\t\t Home URL"));
        $this->create_option('home_url', $home_url, true);

        require_once ABSPATH . "components/loader/TypesLoader.php";
        $admin_id = $this->create_admin();

        echo "\t\t > Create welcome notification" . PHP_EOL;

        require_once ABSPATH . "components/loader/NotificationLoader.php";

        \NotificationLoader::include();

        \Notification::create("Welcome to Project White", $admin_id, $admin_id, "");

        rename(ABSPATH . "_public/install.php", ABSPATH . "_public/install-backup.php");

        require_once ABSPATH . "functions.php";

        echo $this->color->apply(self::INFO, "\n\tProject White installed" . PHP_EOL . "\tvisit " . \get_option('home_url') . " and login with your user information.");

    }

    /**
     * @throws InvalidStyleException
     */
    private function db_config(): \mysqli
    {
        echo "\t\t > Create Database Config" . PHP_EOL;

        if (file_exists(ABSPATH . "config/database.php")) {
            if (self::prompt($this->color->apply(self::TODO, "\t\t\tOverwrite existing config?"))) {
                $this->read_write_database_config();
            } else {
                echo $this->color->apply(self::INFO, "\t\t\t! Configuration not overwritten" . PHP_EOL);
            }
        } else {
            $this->read_write_database_config();
        }

        return \DatabaseLoader::call();
    }

    /**
     * @throws InvalidStyleException
     */
    private function read_write_database_config()
    {
        $db_host = self::input($this->color->apply(self::TODO, "\t\t\tHost"));
        $db_name = self::input($this->color->apply(self::TODO, "\t\t\tDatabase Name"));
        $db_user = self::input($this->color->apply(self::TODO, "\t\t\tUser"));
        $db_password = self::input($this->color->apply(self::TODO, "\t\t\tPassword"));

        echo $this->color->apply(self::INFO, "\t\t > Checking database connection" . PHP_EOL);
        if ($this->check_database_connection($db_host, $db_name, $db_user, $db_password)) {
            echo $this->color->apply(self::INFO, "\t\t   Valid" . PHP_EOL);
            $content = "<?php
const DB_NAME = '$db_name';
const DB_USER = '$db_user';
const DB_PASSWORD = '$db_password';
const DB_HOST= '$db_host';";

            file_put_contents(ABSPATH . "config/database.php", $content);
        } else {
            echo $this->color->apply(self::WARNING, "\t\t   Invalid" . PHP_EOL);
            $this->read_write_database_config();
        }
    }

    private function check_database_connection($db_host, $db_name, $db_user, $db_password): bool
    {
        require_once ABSPATH . "config/database.php";

        try {
            $db = @new \mysqli($db_host, $db_user, $db_password, $db_name);
        } catch (\Exception $e) {
            return false;
        }
        if ($db->connect_errno) {
            return false;
        }
        return true;
    }

    public function create_db($class, $name): void
    {
        global $db;
        echo "\t\t > " . $name . " - " . $class->get_table_name() . PHP_EOL;
        $success = true;
        try {
            $db->query($class->get_create_SQL());
        } catch (\mysqli_sql_exception $e) {
            $success = false;
            echo $this->color->apply(self::WARNING, "\t\t\t ! Table already exists" . PHP_EOL);
            if (self::prompt("\t\t\t Purge and create?")) {
                $db->query("DROP TABLE " . $class->get_table_name());
                echo $this->color->apply(self::INFO, "\t\t\t Table purged" . PHP_EOL);
                $db->query($class->get_create_SQL());
                echo $this->color->apply(self::INFO, "\t\t\t Table created" . PHP_EOL);

            } else {
                echo $this->color->apply(self::INFO, "\t\t\t > Table not created" . PHP_EOL);
            }
        }
        if ($success) {
            echo $this->color->apply(self::INFO, "\t\t\t > Table created" . PHP_EOL);
        }
    }

    /**
     * @throws InvalidStyleException
     */
    public function create_option($name, $value, $autoload = false): void
    {
        echo "\t\t\t Create option '" . $name . "' with value: " . $value . PHP_EOL;
        if (\Options::option_exists($name)) {
            if (self::prompt($this->color->apply(self::WARNING, "\t\t\t\t ! Option already exists - override?"))) {
                \Options::update_option($name, $value, $autoload);
                echo $this->color->apply(self::WARNING, "\t\t\t\t > Option updated" . PHP_EOL);
            } else {
                echo $this->color->apply(self::WARNING, "\t\t\t\t > Option not created" . PHP_EOL);
            }
        } else {
            \Options::set_option($name, $value, $autoload);
            echo $this->color->apply(self::INFO, "\t\t\t\t > Option '" . $name . "' created" . PHP_EOL);
        }
    }

    /**
     * @throws InvalidStyleException
     */
    public function create_admin(): int
    {
        echo "\t\t > Create Admin" . PHP_EOL;
        $firstname = self::input($this->color->apply(self::TODO, "\t\t\tFirstname"));
        $surname = self::input($this->color->apply(self::TODO, "\t\t\tSurname"));
        $email = self::input($this->color->apply(self::TODO, "\t\t\tEmail"));
        $password = self::input($this->color->apply(self::TODO, "\t\t\tPassword"));
        $password_repeat = self::input($this->color->apply(self::TODO, "\t\t\tPassword repeat"));
        $nickname = self::input($this->color->apply(self::TODO, "\t\t\tNickname"));

        if ($firstname && $surname && $email && $password && $password_repeat && $nickname) {

            if ($password == $password_repeat) {
                if ($user = \User::create_user($nickname, $password, $firstname, $surname, $email, false, \User::STATUS_ADMIN)) {
                    return $user->getId();
                    echo $this->color->apply(self::INFO, "\t\t\t > Admin has been created" . PHP_EOL);
                } else {
                    echo $this->color->apply(self::WARNING, "\t\t\t ! A user with the same email or nickname already exists" . PHP_EOL);
                    return self::create_admin();
                }

            } else {
                echo $this->color->apply(self::WARNING, "\t\t\t ! Password does not match" . PHP_EOL);
                return self::create_admin();
            }
        } else {
            echo $this->color->apply(self::WARNING, "\t\t\t ! Information missing - retry" . PHP_EOL);
            return self::create_admin();
        }
    }

    /**
     * @throws InvalidStyleException
     */
    public static function run(mixed $args): void
    {
        new Install($args);
    }
}