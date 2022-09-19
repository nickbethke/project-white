<?php

class DataBaseCore
{
    static function table_exists($table): bool
    {
        global $db;
        if ($result = $db->query("SHOW TABLES LIKE '" . $table . "'")) {
            return (bool) $result->num_rows == 1;
        }
        return false;
    }
}