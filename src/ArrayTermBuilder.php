<?php

class ArrayTermBuilder implements TermBuilder, TermReader
{
    /**
     * @var array
     */
    private $term;

    public function make($t)
    {
        $this->term = array($t);
        return $this;
    }

    public function set($key, $value, $nulls = true)
    {
        if ($value !== null || $nulls) {
            if (!isset($this->term[1])) {
                $this->term[1] = new stdClass();
            }

            $this->term[1]->{$key} = &$value;
        }

        return $this;
    }

    public function get($term, $key)
    {
        return $term[1]->{$key};
    }

    public function build()
    {
        return $this->term;
    }

    /**
     * @param $term
     * @return string
     */
    public function name($term)
    {
        return $term[0];
    }

    /**
     * @param $term
     * @param $key
     * @return boolean
     */
    public function has($term, $key)
    {
        return isset($term[1]->{$key});
    }
}