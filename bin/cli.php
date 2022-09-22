<?php

define("ABSPATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once ABSPATH . "components/abstract/cli/Runnable.php";
if (version_compare(phpversion(), '8.1.0', '<')) {
    echo CLI\Runnable::header();
    echo "\t PHP Version to low\n\t Currently running PHP version " . phpversion() . "\n\t Please use 8.1.0 or higher";
    exit;
}

require_once ABSPATH . "vendor/autoload.php";

require_once ABSPATH . "components/classes/CMD.php";

CMD::run();