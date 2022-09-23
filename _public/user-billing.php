<?php

require_once "../load.php";
require_once "../insession.php";

global $smarty;
$smarty->assign("title", get_option('title', "Project White") . " - Bills");
$smarty->assign("selected_page", "user-billing");

try {
    $smarty->display("user-billing.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}