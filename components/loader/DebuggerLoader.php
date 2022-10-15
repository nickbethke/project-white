<?php


use Tracy\Debugger;

class DebuggerLoader extends Loader
{

    public function load(): bool|null
    {
        Debugger::getBar()->addPanel(new CachePanel());
        Debugger::enable(Debugger::DEVELOPMENT);
        Debugger::$dumpTheme = 'dark';
        return null;
    }

    public static function call(): bool|null
    {
        if (DEBUG) {
            $self = new self;
            $self->load_includes($self->get_includes());
            $self->load();
            return true;
        } else {
            return false;
        }

    }

    protected function get_includes(): array
    {
        return [
            ABSPATH . "/components/classes/debug/CachePanel.php",
            ABSPATH . "/components/classes/debug/UserPanel.php",
            ABSPATH . "/vendor/autoload.php"
        ];
    }
}