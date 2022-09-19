<?php

class Notification
{
    private int $id;
    private User $from;
    private User $to;
    private string $title;
    private string $content;
    private string $dateTime = '0000-00-00 00:00:00';
    private int $status;
    private int $type;

    const STATUS_NEW = 0, STATUS_READ = 1, STATUS_ARCHIVED = 9;
    const TYPE_NORMAL = 0, TYPE_INFO = 1, TYPE_URGENT = 2;

    public function __construct(int $id)
    {
        global $db;

        $SQL = "SELECT * FROM pw_notifications WHERE notification_id = ? LIMIT 1";

        $stmt = $db->prepare($SQL);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $r = $stmt->get_result();
            if ($r->num_rows) {
                $n = $r->fetch_object();
                $this->id = $n->notification_id;
                $this->from = new User($n->notification_from);
                $this->to = new User($n->notification_to);
                $this->title = $n->notification_title;
                $this->content = $n->notification_content;
                $this->dateTime = $n->notification_datetime;
                $this->status = $n->notification_status;
                $this->type = $n->notification_type;
            }
        } else {
            return null;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @return User
     */
    public function getTo(): User
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat("Y-m-d H:i:s", $this->dateTime);
    }

    /**
     * @return Notification::STATUS_NEW|Notification::STATUS_READ|Notification::STATUS_ARCHIVED
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return Notification::TYPE_NORMAL|Notification::TYPE_INFO|Notification::TYPE_URGENT
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param Notification::TYPE_NORMAL|Notification::TYPE_INFO|Notification::TYPE_URGENT $type
     * @return bool
     */
    public function setType(int $type): bool
    {
        $this->type = $type;

        global $db;

        $stmt = $db->prepare("UPDATE pw_notifications SET notification_type = ? WHERE notification_id = ?");

        $stmt->bind_param("ii", $type, $this->id);

        return $stmt->execute();


    }

    /**
     * @param Notification::STATUS_NEW|Notification::STATUS_READ|Notification::STATUS_ARCHIVED $status
     * @return bool
     */
    public function setStatus(int $status): bool
    {
        $this->type = $status;

        global $db;

        $stmt = $db->prepare("UPDATE pw_notifications SET notification_status = ? WHERE notification_id = ?");

        $stmt->bind_param("ii", $status, $this->id);

        return $stmt->execute();
    }


}