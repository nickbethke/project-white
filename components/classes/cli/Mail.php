<?php

namespace CLI;

use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor as ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;
use PHPMailer\PHPMailer\Exception;
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
            default:
                echo Runnable::header();
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
                    echo PHP_EOL . $this->color->apply(self::INFO, "\t\t ●") . ' Email sent!';
                } else {
                    throw new \Exception();
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                echo PHP_EOL . $this->color->apply(self::ALERT, "\t\t ●") . " Email could not be sent";
            }
        } else {
            echo PHP_EOL . $this->color->apply(self::ALERT, "\t\t ●") . " Email could not be sent";
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
        $smtp = new SMTP();

        echo "\t TESTING SMTP CONNECTION" . PHP_EOL . PHP_EOL;

        echo "\t\t HOST: \t\t" . \get_option('smtp_host') . PHP_EOL;
        echo "\t\t USER: \t\t" . \get_option('smtp_user') . PHP_EOL;
        echo "\t\t PASSWORD: \t" . \get_option('smtp_password') . PHP_EOL;
        echo "\t\t PORT: \t\t" . \get_option('smtp_port') . PHP_EOL;
        echo "\t\t ENCRYPTION: \t" . \get_option('smtp_encryption') . PHP_EOL . PHP_EOL;
        echo "\t\t TESTING...";

        try {
            //Connect to an SMTP server
            if (!$smtp->connect(\get_option('smtp_host'), \get_option('smtp_port'))) {
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
                $tlsok = $smtp->startTLS();
                if (!$tlsok) {
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
                if ($smtp->authenticate(\get_option('smtp_user'), \get_option('smtp_password'))) {
                    echo PHP_EOL . $this->color->apply(self::INFO, "\t\t ●") . ' Connected ok!' . PHP_EOL;
                } else {
                    throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
                }
            }
        } catch (Exception $e) {
            echo PHP_EOL . $this->color->apply(self::ALERT, "\t\t ●") . ' SMTP error: ' . $e->getMessage() . PHP_EOL;
        }
//Whatever happened, close the connection.
        $smtp->quit();
    }
}