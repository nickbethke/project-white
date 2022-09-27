<?php

use Composer\InstalledVersions;
use Tracy\Debugger;

require_once "../../load.php";
require_once "../../insession.php";

global $smarty, $db;
$smarty->assign("title", get_option('title', "Project White") . " - System Informations");
$smarty->assign("selected_page", "config-info");

$smarty->assign('db_client_version', $db->client_info);
$smarty->assign('db_server_version', $db->server_info);

$composer_version = false;

if (function_exists('exec')) {
    $h = exec("composer --version");
    if ($h) {
        $composer_version = explode(" ", $h)[2];
    }
}

$smarty->assign('composer_version', $composer_version);
$smarty->assign('smarty_version', InstalledVersions::getVersion('smarty/smarty'));
$smarty->assign('tracy_version', InstalledVersions::getVersion('tracy/tracy'));
$smarty->assign('phpmailer_version', InstalledVersions::getVersion('phpmailer/phpmailer'));


try {
    $smarty->display("config-info.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}