<?php

use ModuleType\OverviewModule;

class Test extends OverviewModule
{
    public function before_head_closed(&$styles, &$scripts): void
    {
        // TODO: Implement before_head_closed() method.
    }

    public function before_overview_print(): void
    {
        // TODO: Implement before_overview_print() method.
    }


}

global $modules;
$modules->register(Test::class);