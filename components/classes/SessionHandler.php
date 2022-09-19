<?php

class Session
{
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;

    // The state of the session
    /**
     * @var mixed|User|null
     */
    private bool $sessionState = self::SESSION_NOT_STARTED;

    // THE only instance of the class
    private static Session $instance;

    private function __construct()
    {
    }

    public static function login(string $email, string $password): bool
    {
        global $db;

        $stmt = $db->prepare("SELECT user_id FROM pw_users WHERE user_email = ? LIMIT 1");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $r = $stmt->get_result();

        $user = new User($r->fetch_assoc()['user_id']);
        if ($user instanceof User && $user->verify_password($password)) {
            Session::getInstance()->set_user($user);
            return true;
        }
        return false;
    }

    public static function logout($redirect = false): void
    {
        Session::getInstance()->set_user(null);
        if($redirect){
            header("Location: /login.php");
            die();
        }
    }

    public static function check_user_state(): bool
    {
        if (array_key_exists("user", $_SESSION)) {
            if ((new DateTime('now'))->getTimestamp() - $_SESSION['user_last_action']->getTimestamp() > 900) {
                unset($_SESSION['user']);
                return false;
            }
            $_SESSION['user_last_action'] = new DateTime('now');
            return true;
        } else {
            return false;
        }
    }

    public function get_user(): User|null
    {
        return new User($_SESSION['user']);
    }

    private
    function set_user(User|null $user): void
    {
        if ($user instanceof User) {
            $_SESSION['user'] = $user->getId();
            $_SESSION['user_last_action'] = new DateTime('now');
        } else {
            unset($_SESSION['user']);
        }
    }

    public
    static function getInstance(): Session
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }

    public
    function startSession(): bool
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }

    public
    function destroy(): bool
    {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);

            return !$this->sessionState;
        }

        return FALSE;
    }

}