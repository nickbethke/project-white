<?php

require_once "../load.php";
require_once "../insession.php";

$smarty->assign("title", get_option('title', "Project White") . " - Projects");
$smarty->assign("selected_page", "projects");

try {
    $smarty->display("projects.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}