<?php

class OptionsCache
{
    private array $cache = [];

    private static OptionsCache $instance;

    public static function getInstance($auto_init = true): OptionsCache
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        $auto_init && self::$instance->auto_init();
        return self::$instance;
    }

    public function __construct($auto_init = true)
    {
        $auto_init && $this->auto_init();
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