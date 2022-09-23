<?php

require_once "../load.php";
require_once "../insession.php";

global $smarty;
$smarty->assign("title", get_option('title', "Project White") . " - User");
$smarty->assign("selected_page", "user");

try {
    $smarty->display("user.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}