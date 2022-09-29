<?php

use ModuleType\OverviewModule;

class Test extends OverviewModule
{
    public function before_overview_head_closed(&$styles, &$scripts): void
    {
        // TODO: Implement before_overview_head_closed() method.
    }

    public function before_overview_body_closed(&$styles, &$scripts): void
    {
        // TODO: Implement before_overview_body_closed() method.
    }

    public function on_overview_print(): void
    {
        // TODO: Implement on_overview_print() method.
    }
    public function on_module_activation(): void
    {
        // TODO: Implement on_module_activation() method.
    }

    public function on_module_deactivation(): void
    {
        // TODO: Implement on_module_deactivation() method.
    }
}

global $modules;
$modules->register(Test::class);