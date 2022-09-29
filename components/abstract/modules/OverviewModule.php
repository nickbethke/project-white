<?php

namespace ModuleType;

use \ModuleType;

abstract class OverviewModule extends ModuleType
{
    public abstract function before_overview_head_closed(&$styles, &$scripts): void;

    public abstract function before_overview_body_closed(&$styles, &$scripts): void;

    public abstract function on_overview_print(): void;
}