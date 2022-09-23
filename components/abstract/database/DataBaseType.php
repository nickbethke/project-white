<?php

abstract class DataBaseType
{
    protected bool $exists = false;

    public function __construct()
    {
        $this->exists = DataBaseCore::table_exists($this->get_table_name());
    }

    public function __set(string $name, mixed $value)
    {
        return null;
    }

    abstract function get_table_name(): string;

    abstract function get_create_SQL(): string;

    public function create(): void
    {
        global $db;
        if (!$this->exists) {
            $cSQL = self::get_create_SQL();
            $db->query($cSQL);

            if ($db->errno) {
                throw new Error("Database table " . $this->get_table_name() . " couldn't be created");
            }
        }
    }
}