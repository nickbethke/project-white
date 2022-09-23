<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

class Mail
{
    private PHPMailer $mailer;

    /**
     * @throws Exception
     */
    public function __construct($debug = false)
    {
        $exceptions = null;
        $this->mailer = new PHPMailer($exceptions);
        $this->mailer->isSMTP();
        if ((defined('DEBUG') && DEBUG) || $debug) {
            $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        }
        $this->mailer->CharSet = PHPMailer::CHARSET_UTF8;
        $this->mailer->Encoding = PHPMailer::ENCODING_BASE64;

        $this->mailer->Host = get_option('smtp_host');
        $this->mailer->SMTPSecure = get_option('smtp_encryption', '');
        $this->mailer->Port = get_option('smtp_port');

        if (get_option('smtp_user') && get_option('smtp_password')) {
            $this->mailer->SMTPAuth = true;

            $this->mailer->Username = get_option('smtp_user');
            $this->mailer->Password = get_option('smtp_password');
        }

        $this->mailer->setFrom(get_option('smtp_user'), "Project White");
    }

    /**
     * @throws Exception
     */
    public function addRecipient(User $user): bool
    {
        return $this->mailer->addAddress($user->getEmail(), $user->getFirstname() . " " . $user->getSurname());
    }

    public function setSubject(string $subject): void
    {
        $this->mailer->Subject = $subject;
    }

    /**
     * @throws Exception
     */
    public function setHTML(string $html): string
    {
        return $this->mailer->msgHTML($html, ABSPATH . "_public");
    }

    /**
     * @throws Exception
     */
    public function send(): bool
    {
        return $this->mailer->send();
    }
}