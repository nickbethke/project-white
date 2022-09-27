<?php

require_once "../../load.php";
require_once "../../insession.php";

global $smarty, $db;
$smarty->assign("title", get_option('title', "Project White") . " - System Informations");
$smarty->assign("selected_page", "config-info");

$smarty->assign('db_client_version', $db->client_info);
$smarty->assign('db_server_version', $db->server_info);

try {
    $smarty->display("config-info.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}