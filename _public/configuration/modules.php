<?php

require_once "../../load.php";
require_once "../../insession.php";

global $smarty;

$availableModules = ModulesRepository::load_available_modules();


$smarty->assign("title", get_option('title', "Project White") . " - Modules");
$smarty->assign("selected_page", "config-modules");
$smarty->assign('available_modules', $availableModules);

try {
    $smarty->display("config-modules.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}