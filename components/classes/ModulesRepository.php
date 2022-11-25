<?php

class ModulesRepository extends Repository
{

    public function __construct()
    {
    }

    public function load_modules(): static
    {
        $modules = \get_option("active_modules");
        return $this;
    }

    public static function load_available_modules(): array
    {
        $modules = [];
        $dir = ABSPATH . "modules";
        $files = scandir($dir);
        foreach ($files as $file) {
            if (!in_array($file, ['.', '..']) && file_exists($dir . "/" . $file . "/module.xml")) {
                if (file_exists($dir . "/" . $file . "/" . $file . ".php")) {
                    $mFile = $file . "/" . $file . ".php";
                } else if (file_exists($dir . "/" . $file . "/index.php")) {
                    $mFile = $file . "/index.php";
                } else {
                    continue;
                }
                $module = new Module($mFile);
                $modules[$module->getPath()] = $module;
            }
        }
        return $modules;

    }

    /**
     * @param string $class
     * @return bool
     * @throws InvalidArgumentException
     */
    public function register(string $class): bool
    {
        if (class_exists($class) && is_a($class, ModuleType::class, true)) {
            $this->repo[] = $class;
            return true;
        } else {
            throw new InvalidArgumentException("Class '" . $class . "' is not an object from type ModuleType", 465);
            return false;
        }
    }

}