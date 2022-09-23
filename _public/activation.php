<?php

require_once "../load.php";

$activationKey = filter_input(INPUT_GET, 'key');
$email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);

if (!$email || !$activationKey) {
    echo "Activation unsuccessful <br>Please contact an admin.";
    exit;
}

if ($user = User::getByEMail($email)) {
    if ($user->getActivationKey() == $activationKey) {
        $user->activate();
        header("Location:" . get_option("home_url"));
        die();
    }
}

echo "Activation unsuccessful <br>Please contact an admin.";
exit;