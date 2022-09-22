<?php

class User
{
    private int $id;
    private string $nickname = "";
    private string $password = "";
    private string $firstname = "";
    private string $surname = "";
    private string $email = "";
    private string $registered = "0000-00-00 00:00:00";
    private string $activation_key = "";
    private int $role = 0;

    const STATUS_USER = 0, STATUS_ADMIN = 1;


    public function __construct(int $id)
    {

        if ($dbUser = DataBaseUser::get_user($id)) {
            $this->id = $id;
            $this->nickname = $dbUser->user_nickname;
            $this->password = $dbUser->user_password;
            $this->firstname = $dbUser->user_firstname;
            $this->surname = $dbUser->user_surname;
            $this->email = $dbUser->user_email;
            $this->registered = $dbUser->user_registered;
            $this->activation_key = $dbUser->user_activation_key;
            $this->role = $dbUser->user_role;
            return $this;
        } else {
            return null;
        }

    }

    public static function create_user(string $nickname, string $clear_password, string $firstname, string $surname, string $email, bool $create_activation_key = true, int $status = 0): null|User
    {
        $password = password_hash($clear_password, PASSWORD_DEFAULT);
        if ($id = DataBaseUser::create_user($nickname, $password, $firstname, $surname, $email, $create_activation_key, $status)) {
            return new self($id);
        } else {
            return null;
        }
    }

    public function is_activated(): bool
    {
        return empty($this->activation_key);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getRegistered(): string
    {
        return $this->registered;
    }

    /**
     * @return DateTime
     */
    public function getRegisteredDateTime(): DateTime
    {
        return DateTime::createFromFormat("Y-m-d H:i:s", $this->registered);
    }

    /**
     * @return string
     */
    public function getActivationKey(): string
    {
        return $this->activation_key;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    public function verify_password(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function activate(): void
    {
        DataBaseUser::activate($this->id);
    }

    public static function getByEMail($email): User|false
    {
        if ($id = DataBaseUser::get_user_id_by_email($email)) {
            return new User($id);
        } else {
            return false;
        }
    }

}