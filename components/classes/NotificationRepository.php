<?php

class NotificationRepository extends Repository implements Iterator
{
    protected mysqli $db;
    /**
     * @var Notification[]
     */
    protected array $repo;

    public function __construct()
    {
        global $db;
        $this->position = 0;
        $this->db = $db;
        $this->repo = [];
    }

    public function search(string $search)
    {
        // TODO: Implement search() method.
    }

    public function length(): int
    {
        return sizeof($this->repo);
    }

    public function get(int $id): ?Notification
    {
        foreach ($this->repo as $notification) {
            if ($notification->getID() == $id) {
                return $notification;
            }
        }
        return null;
    }

    /**
     * @param Notification::STATUS_NEW|Notification::STATUS_READ|Notification::STATUS_ARCHIVED $status
     * @return NotificationRepository
     */
    public function status(int $status): static
    {
        foreach ($this->repo as $key => $notification) {
            if ($notification->getStatus() != $status) {
                unset($this->repo[$key]);
            }
        }
        return $this;
    }

    /**
     * @param Notification::STATUS_NEW|Notification::STATUS_READ|Notification::STATUS_ARCHIVED $status
     * @return NotificationRepository
     */
    public function not_status(int $status): static
    {
        foreach ($this->repo as $key => $notification) {
            if ($notification->getStatus() == $status) {
                unset($this->repo[$key]);
            }
        }
        return $this;
    }

    public function order_by_date(bool $desc = false): static
    {
        if ($desc) {
            usort($this->repo, function ($a, $b) {
                if ($a->getDateTime() == $b->getDateTime()) {
                    return 0;
                }
                return $a->getDateTime() > $b->getDateTime() ? -1 : 1;
            });
        } else {
            usort($this->repo, function ($a, $b) {
                if ($a->getDateTime() == $b->getDateTime()) {
                    return 0;
                }
                return $a->getDateTime() < $b->getDateTime() ? -1 : 1;
            });
        }
        return $this;
    }

    /**
     * @param User $recipient
     * @return static
     */
    public function getAllByRecipient(User $recipient): static
    {
        $stmt = $this->db->prepare("SELECT notification_id FROM pw_notifications WHERE notification_to = ?");

        $id = $recipient->getId();
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $r = $stmt->get_result();
            while ($n = $r->fetch_object()) {
                $this->repo[] = new Notification($n->notification_id);
            }
        }
        return $this;

    }
}