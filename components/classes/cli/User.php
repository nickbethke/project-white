<?php

namespace CLI;

use InitPHP\CLITable\Table;
use \PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor as ConsoleColor;


class User extends Runnable
{
    private ConsoleColor $color;

    public static function run(mixed $args): void
    {
        new User($args);
    }

    public function __construct($args)
    {
        $this->color = new ConsoleColor();
        $action = is_array($args) ? $args[0] : $args;

        switch ($action) {
            case "drop":
                $this->drop_user();
                break;
            case "list":
                $this->list();
                break;
            case "create":
                $this->create_user();
                break;
            case "create::admin":
                $this->create_user(true);
                break;
            default:
                echo Runnable::header();
                echo (new ConsoleColor())->apply(Runnable::WARNING, "\t > Action '$action' missing. Use cli.php help\n\n");
                break;
        }
    }

    private function create_user(bool $admin = false): int
    {
        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        require_once ABSPATH . "components/loader/TypesLoader.php";

        require_once ABSPATH . "components/loader/CacheLoader.php";
        require_once ABSPATH . "components/loader/OptionsLoader.php";
        \OptionsLoader::call();
        require_once ABSPATH . "functions.php";

        global $db;
        $db = \DatabaseLoader::call();

        \TypesLoader::call();
        echo self::header();
        echo $admin ? "\t > Create Admin" . PHP_EOL : "\t > Create User" . PHP_EOL;

        $firstname = self::input($this->color->apply(self::TODO, "\t\tFirstname"));
        $surname = self::input($this->color->apply(self::TODO, "\t\tSurname"));
        $email = self::input($this->color->apply(self::TODO, "\t\tEmail"));
        $password = self::input($this->color->apply(self::TODO, "\t\tPassword"));
        $password_repeat = self::input($this->color->apply(self::TODO, "\t\tPassword repeat"));
        $nickname = self::input($this->color->apply(self::TODO, "\t\tNickname"));

        if ($firstname && $surname && $email && $password && $password_repeat && $nickname) {

            if ($password == $password_repeat) {
                if ($user = \User::create_user($nickname, $password, $firstname, $surname, $email, !$admin, $admin ? \User::STATUS_ADMIN : \User::STATUS_USER)) {
                    !$admin && \mail($email, "Project White - User Activation", "A user has been created for you.<br> <a href='" . \get_option('home_url') . "/activate.php?key=" . $user->getActivationKey() . "&email=" . $email . "'>Activate</a>");
                    echo $this->color->apply(self::INFO, "\t\t > User has been created" . PHP_EOL);
                    return $user->getId();
                } else {
                    echo $this->color->apply(self::WARNING, "\t\t ! A user with the same email or nickname already exists" . PHP_EOL);
                    return self::create_user();
                }

            } else {
                echo $this->color->apply(self::WARNING, "\t\t ! Password does not match" . PHP_EOL);
                return self::create_user();
            }
        } else {
            echo $this->color->apply(self::WARNING, "\t\t ! Information missing - retry" . PHP_EOL);
            return self::create_user();
        }
    }

    private function drop_user()
    {
        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        require_once ABSPATH . "components/loader/TypesLoader.php";
        global $db;
        $db = \DatabaseLoader::call();

        \TypesLoader::call();
        echo self::header();
        echo "\t > Drop User" . PHP_EOL;

        $id = self::input($this->color->apply(self::TODO, "\t\tUser ID"));
        if ($id && \DataBaseUser::user_exists($id)) {
            $user = new \User($id);
            $user->deactivate();
            if (self::prompt($this->color->apply(self::TODO, "\t\t > Drop user " . $user->getFirstname() . " " . $user->getSurname() . " (" . $id . ")"))) {
                echo $this->color->apply(self::INFO, "\t\t > User dropped" . PHP_EOL);
            } else {
                echo $this->color->apply(self::WARNING, "\t\t > User not dropped" . PHP_EOL);
            }
        } else {
            echo $this->color->apply(self::WARNING, "\t\t > User not existing" . PHP_EOL);
        }
    }

    private function list()
    {
        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        require_once ABSPATH . "components/loader/TypesLoader.php";
        global $db;
        $db = \DatabaseLoader::call();

        \TypesLoader::call();
        echo self::header();

        echo $this->color->apply(self::INFO, " Listing all users" . PHP_EOL);

        $users = \User::get_all_active();
        $table = new Table();
        foreach ($users as $user) {
            $table->row([
                'ID' => $user->getId(),
                'name' => $user->getFirstname() . " " . $user->getSurname(),
                'nickname' => $user->getNickname(),
                'registered' => $user->getRegisteredDateTime()->format("m-d-Y H:i:s"),
                'email' => $user->getEmail(),
                'role' => $user->getRole() == \User::STATUS_ADMIN ? "- ADMIN -" : "default"
            ]);
        }
        echo $table;
    }
}