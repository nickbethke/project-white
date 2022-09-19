<?php

require_once "../load.php";
require_once "../insession.php";
global $smarty;

$smarty->assign("title", get_option('title', "Project White") . " - Inbox");
$smarty->assign("selected_page", "inbox");

if (array_key_exists('action', $_GET)) {
    $action = filter_input(INPUT_GET, 'action');

    $smarty->assign("title", get_option('title', "Project White") . " - Create Notification");
    $smarty->assign("selected_page", "inbox-create");

    try {
        $smarty->display("inbox-create.tpl");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    die();
}

if (array_key_exists('view', $_GET)) {

    $not = new Notification($_GET['view']);
    $not->setStatus(Notification::STATUS_READ);
    $smarty->assign('notification', $not);

    $smarty->assign("title", get_option('title', "Project White") . " - View Notification - " . $not->getTitle());

    try {
        $smarty->display("inbox-view.tpl");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    if (array_key_exists('status', $_GET)) {
        $status = filter_input(INPUT_GET, 'status');
        $notifications = null;
        switch ($status) {
            case 'new':
                $notifications = (new NotificationRepository())->getAllByRecipient(Session::getInstance()->get_user())->status(Notification::STATUS_NEW)->order_by_date(true);
                $smarty->assign("selected_page", "inbox-new");
                break;
            case 'archived':
                $notifications = (new NotificationRepository())->getAllByRecipient(Session::getInstance()->get_user())->status(Notification::STATUS_ARCHIVED)->order_by_date(true);
                $smarty->assign("selected_page", "inbox-archived");
                break;
        }
    } else {
        $notifications = (new NotificationRepository())->getAllByRecipient(Session::getInstance()->get_user())->order_by_date(true);
    }

    $smarty->assign('notification_repo', $notifications);

    try {
        $smarty->display("inbox.tpl");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

