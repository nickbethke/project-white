<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_ERROR);

define("ABSPATH", dirname(__FILE__) . DIRECTORY_SEPARATOR);
define("DEBUG", true);

require_once ABSPATH . "components/abstract/Loader.php";

require_once ABSPATH . "components/loader/SmartyLoader.php";
$smarty = SmartyLoader::call();

require_once ABSPATH . "components/loader/DebuggerLoader.php";
DebuggerLoader::call();

require_once ABSPATH . "components/loader/CacheLoader.php";
require_once ABSPATH . "components/loader/TypesLoader.php";

require_once ABSPATH . "components/loader/OptionsLoader.php";
OptionsLoader::call();

require_once ABSPATH . "components/loader/SessionLoader.php";

require_once ABSPATH . "components/loader/DatabaseLoader.php";

require_once ABSPATH . "components/loader/NotificationLoader.php";

require_once ABSPATH . "components/classes/Language.php";

require_once ABSPATH . "functions.php";


global $db, $optionCache, $notRepo;

$db = DatabaseLoader::call();

$optionCache = CacheLoader::call();

TypesLoader::call();
$session = SessionLoader::call();

$smarty->assign("char_set", get_option('char_set'));
$smarty->assign("lang_code", get_option('lang_code'));
$smarty->assign("title", get_option('title', "Project White"));
$smarty->assign("home_url", get_option('home_url'));
$smarty->assign("selected_page", "home");

$smarty->assign('favicon',favicon());