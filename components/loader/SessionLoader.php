<?php

class SessionLoader extends Loader
{

    public function load(): Session
    {
        return Session::getInstance();
    }

    protected function get_includes(): array
    {
        return [ABSPATH . "components/classes/SessionHandler.php"];
    }

    public static function call(): Session
    {
        $self = new self;
        $self->load_includes($self->get_includes());
        return $self->load();
    }
}