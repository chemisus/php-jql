<?php

class ObjectTermBuilder implements TermBuilder
{
    private $term;

    public function make($t)
    {
        $this->term = new stdClass();
        $this->term->t = $t;
        return $this;
    }

    public function set($key, $value, $nulls = true)
    {
        if ($value !== null || $nulls) {
            $this->term->{$key} = $value;
        }

        return $this;
    }

    public function get($value, $key)
    {
        return $value->{$key};
    }

    public function build()
    {
        return $this->term;
    }
}