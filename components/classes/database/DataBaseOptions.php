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

            $auto = $autoload ? 1 : 0;
            $stmt->bind_param("ssi", $name, $value, $auto);

            return $stmt->execute();
        } else {
            return false;
        }

    }

    function update_option($name, $value): bool
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
        $check = random_bytes(16);
        return !boolval($this->get_option($name, $check) == $check);
    }

    function get_option($option, $default): mixed
    {
        global $db, $optionCache;

        if (empty($option)) {
            return false;
        }
        if ($optionCache instanceof OptionsCache) {
            if ($optionCache->in_cache($option)) {
                return $optionCache->get_cached_option($option);
            }
        }

        $SQL = "SELECT `option_value` FROM `pw_options` WHERE `option_name` = ? LIMIT 1";


        $stmt = $db->prepare($SQL);
        $stmt->bind_param("s", $option);

        $stmt->execute();

        $r = $stmt->get_result();

        if ($r->num_rows < 1) {
            return $default;
        } else {
            $v = $r->fetch_assoc()['option_value'];
            if ($optionCache instanceof OptionsCache) {
                return $optionCache->set_cached_option($option, $v);
            }
            return $v;
        }
    }

    public function get_all_options(): array
    {
        global $db;
        $stmt = $db->prepare("SELECT `option_id`,`option_name`,`option_value`,`autoload` FROM `pw_options`");

        $stmt->execute();

        $stmt->bind_result($id, $name, $value, $autoload);

        $options = [];
        while ($stmt->fetch()) {
            $options[$name] = [
                "id" => $id,
                "name" => $name,
                "value" => $value,
                "autoload" => $autoload
            ];
        }
        return $options;
    }

    public function delete_option(string $name): bool
    {
        if ($this->option_exists($name)) {
            global $db;
            $SQL = "DELETE FROM pw_options WHERE option_name = ?";
            $stmt = $db->prepare($SQL);
            $stmt->bind_param("s", $name);

            $stmt->execute();
            return boolval($stmt->num_rows());
        }
        return false;
    }
}