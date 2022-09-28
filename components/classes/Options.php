<?php

class Options
{
    static function get_option(string $option, mixed $default = false): mixed
    {
        $v = (new DataBaseOptions())->get_option($option, $default);
        if (self::is_json($v)) {
            return json_decode($v, true);
        }
        return $v;
    }

    static function set_option(string $option, mixed $value, $autoload = false): bool
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return (new DataBaseOptions())->set_option($option, $value, $autoload);
    }

    static function option_exists(string $option): bool
    {
        return (new DataBaseOptions())->option_exists($option);
    }

    public static function update_option(string $name, mixed $value): bool
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return (new DataBaseOptions())->update_option($name, $value);
    }

    public static function delete_option(string $name): bool
    {
        return (new DataBaseOptions())->delete_option($name);
    }

    public static function get_all_options(): array
    {
        return (new DataBaseOptions())->get_all_options();
    }

    public static function is_json(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}