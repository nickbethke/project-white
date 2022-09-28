<?php

require_once "../../load.php";
require_once "../../insession.php";

global $smarty;

if ($module = filter_input(INPUT_GET, 'deactivate')) {
    Module::deactivate($module);
    header("Location: " . get_option("home_url") . "configuration/modules.php");
    exit;
}
if ($module = filter_input(INPUT_GET, 'activate')) {
    Module::activate($module);
    header("Location: " . get_option("home_url") . "configuration/modules.php");
    exit;
}
if ($module = filter_input(INPUT_GET, 'config')) {
    exit;
}


$availableModules = ModulesRepository::load_available_modules();


$smarty->assign("title", get_option('title', "Project White") . " - Modules");
$smarty->assign("selected_page", "config-modules");
$smarty->assign('available_modules', $availableModules);
$smarty->assign('active_modules', \get_option("active_modules"));

try {
    $smarty->display("config-modules.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}