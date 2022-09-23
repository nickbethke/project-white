<?php

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $exceptions = null;
        $this->mailer = new PHPMailer($exceptions);
    }
}