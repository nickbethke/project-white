<?php


class DataBaseUser extends DataBaseType
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_table_name(): string
    {
        return "pw_users";
    }

    function get_create_SQL(): string
    {
        return "CREATE TABLE " . $this->get_table_name() . "
        (
            `user_id`             BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
            `user_nickname`       VARCHAR(60)         NOT NULL DEFAULT '',
            `user_password`       VARCHAR(255)        NOT NULL DEFAULT '',
            `user_firstname`      VARCHAR(50)         NOT NULL DEFAULT '',
            `user_surname`        VARCHAR(50)         NOT NULL DEFAULT '',
            `user_email`          VARCHAR(100)        NOT NULL DEFAULT '',
            `user_registered`     datetime            NOT NULL DEFAULT '0000-00-00 00:00:00',
            `user_activation_key` VARCHAR(255)        NOT NULL DEFAULT '',
            `user_status`         int(11)             NOT NULL DEFAULT '0',
            PRIMARY KEY (user_id),
            KEY user_email (user_email)
        )";
    }

    /**
     * @param int $userID
     * @param bool $assoc
     * @return DataBaseUserType|array
     */
    public static function get_user(int $userID, bool $assoc = false): stdClass|array
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM pw_users WHERE user_id = ? LIMIT 1");

        $stmt->bind_param("i", $userID);

        $stmt->execute();

        $r = $stmt->get_result();

        return $assoc ? $r->fetch_assoc() : $r->fetch_object();
    }

    public static function create_user(string $nickname, string $password, string $firstname, string $surname, string $email, bool $create_activation_key = true, int $status = 0): bool|int
    {

        global $db;

        $stmt = $db->prepare("SELECT `user_id` FROM `pw_users` WHERE `user_email` = ? OR `user_nickname` = ? LIMIT 1;");

        $stmt->bind_param("ss", $email, $nickname);

        $stmt->execute();

        $r = $stmt->get_result();

        $stmt = null;
        if ($r->num_rows < 1) {

            if ($create_activation_key) {
                $generated_key = sha1(mt_rand(10000, 99999) . time() . $email);

                $stmt = $db->prepare("INSERT INTO pw_users (user_nickname, user_password, user_firstname, user_surname, user_email, user_registered, user_activation_key, user_status)  VALUES (?,?,?,?,?,CURRENT_TIMESTAMP,?,?)");
                $stmt->bind_param("ssssssi", $nickname, $password, $firstname, $surname, $email, $generated_key, $status);
            } else {
                $stmt = $db->prepare("INSERT INTO pw_users (user_nickname, user_password, user_firstname, user_surname, user_email, user_registered, user_status) VALUES (?,?,?,?,?,CURRENT_TIMESTAMP,?)");
                $stmt->bind_param("sssssi", $nickname, $password, $firstname, $surname, $email, $status);
            }
            if ($stmt->execute()) {
                return $db->insert_id;
            } else {
                return false;
            }

        } else {
            return false;
        }


    }
}

/**
 * @property int user_id
 * @property string user_nickname
 * @property string user_password
 * @property string user_firstname
 * @property string user_surname
 * @property string user_email
 * @property string user_registered
 * @property string user_activation_key
 * @property int user_role
 */
class DataBaseUserType extends stdClass
{

}
