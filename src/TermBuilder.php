<?php

interface TermBuilder
{
    /**
     * @param $name
     * @return TermBuilder
     */
    public function make($name);

    /**
     * @param $key
     * @param $term
     * @param bool $nulls
     * @return TermBuilder
     */
    public function set($key, $term, $nulls = true);

    /**
     * @return mixed
     */
    public function build();
}