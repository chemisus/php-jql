<?php

interface TermReader
{
    /**
     * @param $term
     * @return string
     */
    public function name($term);

    /**
     * @param $term
     * @param $key
     * @return mixed
     */
    public function get($term, $key);

    /**
     * @param $term
     * @param $key
     * @return boolean
     */
    public function has($term, $key);
}