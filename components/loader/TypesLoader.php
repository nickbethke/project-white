<?php

class TypesLoader extends Loader
{

    public function load(): mixed
    {
        return null;
    }

    protected function get_includes(): array
    {
        return [ABSPATH . "components/classes/types/User.php"];
    }

    public static function call(): mixed
    {
        $self = new self;
        $self->load_includes($self->get_includes());
        return $self->load();
    }
}