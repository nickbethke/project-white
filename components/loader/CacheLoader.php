<?php

class CacheLoader extends Loader
{

    public function load($auto = true): OptionsCache
    {
        return OptionsCache::getInstance($auto);
    }

    protected function get_includes(): array
    {
        return [ABSPATH . "components/classes/OptionsCache.php"];
    }

    public static function call($auto = true): OptionsCache
    {
        $self = new self;
        $self->load_includes($self->get_includes());
        return $self->load($auto);

    }
}