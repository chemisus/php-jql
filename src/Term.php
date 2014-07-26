<?php

interface Term
{
    /**
     * @param Environment $env
     * @param  $term
     * @return mixed
     */
    public function run(Environment $env, $term);

    /**
     * @param Environment $env
     * @param $term
     * @return boolean
     */
    public function verify(Environment $env, $term);

    /**
     * @return string
     */
    public function name();
}