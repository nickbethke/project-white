<?php

abstract class ModuleType
{
    public abstract function on_module_activation(): void;

    public abstract function on_module_deactivation(): void;

}