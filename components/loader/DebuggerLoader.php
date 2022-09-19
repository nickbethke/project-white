<?php


class DebuggerLoader extends Loader
{

    public function load(): bool|null
    {
        \Tracy\Debugger::getBar()->addPanel(new CachePanel());
        \Tracy\Debugger::enable(\Tracy\Debugger::DEVELOPMENT);
        \Tracy\Debugger::$dumpTheme = 'dark';
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
        return array(ABSPATH . "/components/classes/CachePanel.php", ABSPATH . "/components/classes/UserPanel.php", ABSPATH . "/vendor/autoload.php");
    }
}