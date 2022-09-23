<?php

use Tracy\Debugger;

require_once "../load.php";

$post = get_post_vars();

if ($post && sizeof($post) > 0) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password');
    $h = Session::login($email, $password) ? "" : "login.php?state=false";
    header("Location: " . get_option('home_url') . $h);
    die();
}

global $smarty;
$state = !(filter_input(INPUT_GET, 'state') == "false");
$smarty->assign("title", get_option('title', "Project White") . " - Login");
$smarty->assign('success', $state);

Debugger::$showBar = false;

try {
    $smarty->display("login.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}