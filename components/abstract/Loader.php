<?php

abstract class Loader
{
    abstract public function load(): mixed;

    abstract protected function get_includes(): array;

    public function load_includes(array|bool $includes = false): void
    {
        if ($includes === false) {
            $includes = $this->get_includes();
        }
        foreach ($includes as $include) {
            if (file_exists($include)) {
                require_once $include;
            } else {
                throw new \Symfony\Component\Filesystem\Exception\FileNotFoundException("File Not Found", 1, null, $include);
            }
        }
    }

    abstract public static function call(): mixed;
}