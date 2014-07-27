<?php

class ObjectTermBuilder implements TermBuilder, TermReader
{
    /**
     * @var stdClass
     */
    private $term;

    /**
     * @param string $t
     * @return $this|TermBuilder
     */
    public function make($t)
    {
        $this->term = new stdClass();
        $this->term->t = $t;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @param bool $nulls
     * @return $this|TermBuilder
     */
    public function set($key, $value, $nulls = true)
    {
        if ($value !== null || $nulls) {
            $this->term->{$key} = &$value;
        }

        return $this;
    }

    /**
     * @param $term
     * @param $key
     * @return mixed
     */
    public function get($term, $key)
    {
        return $term->{$key};
    }

    /**
     * @return stdClass
     */
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
        return $term->t;
    }

    /**
     * @param $term
     * @param $key
     * @return boolean
     */
    public function has($term, $key)
    {
        return isset($term->{$key});
    }
}