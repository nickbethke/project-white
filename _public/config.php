<?php

require_once "../load.php";
require_once "../insession.php";

$smarty->assign("title", get_option('title', "Project White") . " - Configuration");
$smarty->assign("selected_page", "config");

try {
    $smarty->display("config.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}