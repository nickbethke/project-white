<?php

class NotificationLoader extends Loader
{

    public function load(): bool
    {
        new NotificationRepository();
        return true;
    }

    protected function get_includes(): array
    {
        return [ABSPATH . "components/abstract/Repository.php", ABSPATH . "components/classes/types/Notification.php", ABSPATH . "components/classes/NotificationRepository.php"];

    }

    public static function call(): bool
    {
        $self = new self;
        $self->load_includes($self->get_includes());
        return $self->load();
    }
}