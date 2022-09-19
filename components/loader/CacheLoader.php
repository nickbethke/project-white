<?php

class CacheLoader extends Loader
{

    public function load(): OptionsCache
    {
        return new OptionsCache();
    }

    protected function get_includes(): array
    {
        return [ABSPATH . "components/classes/OptionsCache.php"];
    }

    public static function call(): OptionsCache
    {
        $self = new self;
        $self->load_includes($self->get_includes());
        return $self->load();

    }
}