<?php

class DataBaseNotifications extends DataBaseType
{
    public function get_create_SQL(): string
    {
        return "create table " . $this->get_table_name() . "
        (
    notification_id       bigint unsigned auto_increment
        primary key,
    notification_from     bigint unsigned                        not null,
    notification_to       bigint unsigned                        not null,
    notification_title    text     default ''                    not null,
    notification_content  longtext default ''                    not null,
    notification_datetime datetime default '0000-00-00 00:00:00' not null,
    notification_status   int(2)   default 0                     not null,
    notification_type     int(2)   default 0                     not null,
    constraint FK_NotificationFromUser
        foreign key (notification_from) references pw_users (user_id),
    constraint FK_NotificationToUser
        foreign key (notification_to) references pw_users (user_id)
    );";
    }

    function get_table_name(): string
    {
        return "pw_notifications";
    }
}