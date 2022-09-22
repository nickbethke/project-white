<?php

Session::check_user_state() ? null : Session::logout(true);
\Tracy\Debugger::getBar()->addPanel(new UserPanel());

if ($session->get_user() == null) {
    $session->logout();
    header("Loaction: " . get_option("home_url"));
    exit;
}
$user = $session->get_user();

$smarty->assign("user", $user);

NotificationLoader::call();

$notificationCount = (new NotificationRepository())->getAllByRecipient(Session::getInstance()->get_user())->status(Notification::STATUS_NEW)->length();

$smarty->assign("notifications", $notificationCount);