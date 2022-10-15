<?php

namespace CLI;

use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor as ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail extends Runnable
{
    private ConsoleColor $color;

    /**
     * @throws InvalidStyleException
     */
    public function __construct($args)
    {
        echo self::header();

        $this->color = new ConsoleColor();
        $action = is_array($args) ? $args[0] : $args;

        switch ($action) {
            case "send::test":
                $this->sendTest();
                break;
            case "smtp::check":
                $this->checkSMTP();
                break;
            case "smtp::configure":
                $this->configureSMTP();
                break;
            default:
                echo $this->color->apply(Runnable::WARNING, "\t > Action '$action' missing. Use cli.php help\n\n");
                break;
        }
    }

    public static function run(mixed $args): void
    {
        new self($args);
    }

    /**
     * @throws InvalidStyleException
     */
    private function sendTest()
    {
        echo "\tSending Test-Mail" . PHP_EOL;
        $id = self::input($this->color->apply(self::TODO, "\t\t User ID"));

        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        require_once ABSPATH . "components/loader/TypesLoader.php";
        global $db;
        $db = \DatabaseLoader::call();

        \TypesLoader::call();

        if ($id && \DataBaseUser::user_exists($id)) {

            $user = new \User($id);
            require_once ABSPATH . "components/classes/Mail.php";
            require_once ABSPATH . "components/loader/SmartyLoader.php";
            require_once ABSPATH . "components/classes/Options.php";
            require_once ABSPATH . "functions.php";
            $smarty = \SmartyLoader::call();

            try {
                echo "\t\t Sending Test-Mail to " . $user->getEmail();
                $mail = new \Mail();
                $mail->addRecipient($user);
                $mail->setSubject("Project White - Test Email");
                $mail->setHTML($smarty->fetch("mail/test-mail.tpl"));
                if ($mail->send()) {
                    echo PHP_EOL . $this->color->apply(self::INFO, "\t\t ●") . ' Connected ok!';
                    echo PHP_EOL . $this->color->apply(self::INFO, "\t\t ●") . ' Email sent!' . PHP_EOL;
                } else {
                    throw new \Exception();
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                echo PHP_EOL . $this->color->apply(self::ALERT, "\t\t ●") . " Email could not be sent" . PHP_EOL;
            }
        } else {
            echo PHP_EOL . $this->color->apply(self::ALERT, "\t\t ●") . " Email could not be sent" . PHP_EOL;
        }
    }

    private function checkSMTP()
    {
        require_once ABSPATH . "components/abstract/Loader.php";
        require_once ABSPATH . "components/loader/DatabaseLoader.php";
        global $db;
        $db = \DatabaseLoader::call();
        require_once ABSPATH . "components/classes/Options.php";
        require_once ABSPATH . "functions.php";

        $host = \get_option('smtp_host');
        $user = \get_option('smtp_user');
        $password = \get_option('smtp_password');
        $port = \get_option('smtp_port');
        $encryption = \get_option('smtp_encryption');


        $smtp = new SMTP();

        echo "\t TESTING SMTP CONNECTION" . PHP_EOL . PHP_EOL;

        echo "\t\t HOST \t\t" . $host . PHP_EOL;
        echo "\t\t USER \t\t" . $user . PHP_EOL;
        echo "\t\t PASSWORD \t" . str_repeat('•', strlen($password)) . PHP_EOL;
        echo "\t\t PORT \t\t" . $port . PHP_EOL;
        echo "\t\t ENCRYPTION \t" . $encryption . PHP_EOL . PHP_EOL;
        echo "\t\t TESTING...";

        try {
            //Connect to an SMTP server
            if (!$smtp->connect($host, $port)) {
                throw new Exception('Connect failed');
            }
            //Say hello
            if (!$smtp->hello(gethostname())) {
                throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
            }
            //Get the list of ESMTP services the server offers
            $e = $smtp->getServerExtList();
            //If server can do TLS encryption, use it
            if (is_array($e) && array_key_exists('STARTTLS', $e)) {
                $tls = $smtp->startTLS();
                if (!$tls) {
                    throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
                }
                //Repeat EHLO after STARTTLS
                if (!$smtp->hello(gethostname())) {
                    throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
                }
                //Get new capabilities list, which will usually now include AUTH if it didn't before
                $e = $smtp->getServerExtList();
            }
            //If server supports authentication, do it (even if no encryption)
            if (is_array($e) && array_key_exists('AUTH', $e)) {
                if ($smtp->authenticate($user, $password)) {
                    echo PHP_EOL . $this->color->apply(self::INFO, "\t\t ●") . ' Connected ok!' . PHP_EOL;
                } else {
                    throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
                }
            }
        } catch (Exception|InvalidStyleException $e) {
            echo PHP_EOL . $this->color->apply(self::ALERT, "\t\t ●") . ' SMTP error: ' . $e->getMessage() . PHP_EOL;
        }
//Whatever happened, close the connection.
        $smtp->quit();
    }

    /**
     * @throws InvalidStyleException
     */
    private function configureSMTP()
    {
        echo "\tConfigure SMTP" . PHP_EOL;

        $smtp_host = self::input($this->color->apply(self::TODO, "\t\t SMTP Host"));
        $this->create_option('smtp_host', $smtp_host, true);

        $smtp_user = self::input($this->color->apply(self::TODO, "\t\t SMTP User"));
        $this->create_option('smtp_user', $smtp_user, true);

        $smtp_password = self::input($this->color->apply(self::TODO, "\t\t SMTP Password"));
        $this->create_option('smtp_password', $smtp_password, true);

        $smtp_encryption = self::input_select($this->color->apply(self::TODO, "\t\t SMTP Encryption"), "\t\t\t", PHPMailer::ENCRYPTION_SMTPS, PHPMailer::ENCRYPTION_STARTTLS);
        $this->create_option('smtp_encryption', $smtp_encryption, true);

        $smtp_port = self::input($this->color->apply(self::TODO, "\t\t SMTP Port"));
        $this->create_option('smtp_port', $smtp_port, true);
    }

}