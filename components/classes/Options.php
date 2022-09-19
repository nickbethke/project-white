<?php

class Options
{
    static function get_option(string $option, mixed $default = false): mixed
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