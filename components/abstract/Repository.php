<?php

abstract class Repository implements Iterator
{
    protected array $repo;
    protected int $position = 0;

    #[ReturnTypeWillChange] public function current()
    {
        return $this->repo[$this->position];
    }

    #[ReturnTypeWillChange] public function next()
    {
        ++$this->position;
    }

    #[ReturnTypeWillChange] public function key()
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->repo[$this->position]);
    }

    #[ReturnTypeWillChange] public function rewind()
    {
        $this->position = 0;
    }

}