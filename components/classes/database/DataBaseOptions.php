<?php

class DataBaseOptions extends DataBaseType
{

    function get_table_name(): string
    {
        return "pw_options";
    }

    function get_create_SQL(): string
    {
        return "create table " . $this->get_table_name() . "
(
    option_id    bigint unsigned auto_increment
        primary key,
    option_name  varchar(64) default ''    not null,
    option_value longtext                  not null,
    autoload     varchar(20) default 'yes' not null,
    constraint option_name
        unique (option_name)
) charset = utf8;";
    }

    function set_option($name, $value, $autoload = false): bool
    {
        if (!$this->option_exists($name)) {
            global $db;

            $SQL = "INSERT INTO pw_options (option_name, option_value, autoload) VALUES (?,?,?)";

            $stmt = $db->prepare($SQL);

            $stmt->bind_param("ssi", $name, $value, $autoload);

            return $stmt->execute();
        } else {
            return false;
        }

    }

    function update_option($name, $value, $autoload = false): bool
    {
        if ($this->option_exists($name)) {
            global $db;
            $SQL = "UPDATE pw_options SET option_value = ? WHERE option_name = ?";
            $stmt = $db->prepare($SQL);
            $stmt->bind_param("ss", $value, $name);

            $stmt->execute();
            return boolval($stmt->num_rows());
        }
        return false;
    }

    function option_exists($name): bool
    {
        return boolval($this->get_option($name, false));
    }

    function get_option($option, $default): mixed
    {
        global $db, $optionCache;

        if (empty($option)) {
            return false;
        }

        if ($optionCache->in_cache($option)) {
            return $optionCache->get_cached_option($option);
        }

        $SQL = "SELECT `option_value` FROM `pw_options` WHERE `option_name` = ? LIMIT 1";


        $stmt = $db->prepare($SQL);
        $stmt->bind_param("s", $option);

        $stmt->execute();

        $r = $stmt->get_result();

        if ($r->num_rows < 1) {
            return $default;
        } else {
            return $r->fetch_assoc()['option_value'];
        }
    }
}