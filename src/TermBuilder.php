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
     * @param $value
     * @param bool $nulls
     * @return TermBuilder
     */
    public function set($key, $value, $nulls = true);

    /**
     * @return mixed
     */
    public function build();
}