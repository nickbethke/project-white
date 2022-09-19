<?php

require_once "../load.php";

$post = get_post_vars();

if ($post && sizeof($post) > 0) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $h = Session::login($email, $password) ? "/" : "/login.php";
    header("Location: " . $h);
    die();
}

global $smarty;

$smarty->assign("title", get_option('title', "Project White") . " - Login");

\Tracy\Debugger::$showBar = false;

try {
    $smarty->display("login.tpl");
} catch (Exception $e) {
    echo $e->getMessage();
}