<?php

class OptionsCache
{
    private array $cache = [];

    public function __construct()
    {
        $this->auto_init();
    }

    private function auto_init(): void
    {
        global $db;
        $stmt = $db->prepare("SELECT `option_name`,`option_value` FROM `pw_options` WHERE `autoload` = 'yes'");

        $stmt->execute();

        $stmt->bind_result($name, $value);

        /* fetch values */
        while ($stmt->fetch()) {
            $this->cache[$name] = $value;
        }
    }

    public function in_cache($option): bool
    {
        return array_key_exists($option, $this->cache);
    }

    public function get_cached_option($option): mixed
    {
        if ($this->in_cache($option)) {
            return $this->cache[$option];
        } else {
            return null;
        }
    }

    public function get_cache(): array
    {
        return $this->cache;
    }
}