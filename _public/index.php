<?php

require_once "../load.php";
require_once "../insession.php";

global $smarty;

$smarty->assign("title", get_option('title', "Project White") . " - Dashboard");
$smarty->assign("selected_page", "home");

try {
    $smarty->display("index.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}