<?php

class DatabaseLoader extends Loader
{

    public function load(): mysqli
    {
        require_once ABSPATH . "config/database.php";

        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($db->connect_errno) {
            throw new Error("mysqli connect error: " . $db->connect_error, $db->connect_errno);
        }
        $db->set_charset("utf8");
        return $db;
    }

    protected function get_includes(): array
    {
        return [
            ABSPATH . "components/abstract/database/DataBaseType.php",
            ABSPATH . "components/classes/database/DataBaseCore.php",
            ABSPATH . "components/classes/database/DataBaseUser.php",
            ABSPATH . "components/classes/database/DataBaseNotifications.php",
            ABSPATH . "components/classes/database/DataBaseOptions.php"
        ];
    }

    /**
     * Loading the database connection and loading all includes
     * @return mysqli
     */
    public static function call(): mysqli
    {
        $self = new self;
        $self->load_includes($self->get_includes());
        return $self->load();
    }
}