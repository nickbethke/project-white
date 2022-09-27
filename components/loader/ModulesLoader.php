<?php

class ModulesLoader extends Loader
{

    public function load(): ModulesRepository
    {
        return new ModulesRepository();
    }

    protected function get_includes(): array
    {
        return [
            ABSPATH . "components/abstract/Repository.php",
            ABSPATH . "components/classes/ModulesRepository.php",
            ABSPATH . "components/abstract/Module.php",
            ABSPATH . "components/classes/types/Module.php",
            ABSPATH . "components/abstract/modules/OverviewModule.php"
        ];
    }

    public static function call(): ModulesRepository
    {
        $self = new self;
        $self->load_includes($self->get_includes());
        return $self->load();
    }
}