<?php

class SmartyLoader extends Loader
{

    public function load(): Smarty
    {
        $smarty = new Smarty();
        $smarty->setTemplateDir(ABSPATH . 'smarty/templates');
        $smarty->setConfigDir(ABSPATH . 'smarty/config');
        $smarty->setCompileDir(ABSPATH . 'smarty/compile');
        $smarty->setCacheDir(ABSPATH . 'smarty/cache');

        $smarty->caching = Smarty::CACHING_OFF;

        return $smarty;
    }

    public function get_includes(): array
    {
        return array(ABSPATH . "/vendor/autoload.php");
    }

    public static function call(): Smarty
    {
        $self = new self;
        $self->load_includes($self->get_includes());
        return $self->load();
    }
}