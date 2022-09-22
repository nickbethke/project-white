<?php

define("ABSPATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once ABSPATH . "vendor/autoload.php";

require_once ABSPATH . "components/abstract/Loader.php";
require_once ABSPATH . "components/loader/TypesLoader.php";
require_once ABSPATH . "components/loader/DatabaseLoader.php";

global $db;
$db = DatabaseLoader::call();
TypesLoader::call();

require_once ABSPATH . "components/loader/CacheLoader.php";
require_once ABSPATH . "components/loader/OptionsLoader.php";

global $optionCache;
$optionCache = CacheLoader::call(false);
OptionsLoader::call();

require_once ABSPATH . "components/classes/CMD.php";

CMD::run();