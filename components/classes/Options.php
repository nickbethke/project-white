<?php

class Options
{
    static function get_option(string $option, mixed $default = false): mixed
    {
        return (new DataBaseOptions())->get_option($option, $default);
    }

    static function set_option(string $option, mixed $value, $autoload = false): bool
    {
        return (new DataBaseOptions())->set_option($option, $value, $autoload);
    }

    static function option_exists(string $option): bool
    {
        return (new DataBaseOptions())->option_exists($option);
    }

    public static function update_option(string $name, mixed $value): bool
    {
        return (new DataBaseOptions())->update_option($name, $value);
    }
}