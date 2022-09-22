<?php

namespace CLI;

class NoAction extends Runnable
{

    public static function run(mixed $args): void
    {
        echo self::header();
    }
}