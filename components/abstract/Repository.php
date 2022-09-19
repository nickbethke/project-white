<?php

abstract class Repository implements Iterator
{
    protected array $repo;
    protected int $position = 0;

    public abstract function get(int $id);

    public function current()
    {
        return $this->repo[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->repo[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

}