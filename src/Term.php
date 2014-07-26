<?php

interface Term
{
    /**
     * @param Environment $env
     * @param stdClass $value
     * @return mixed
     */
    public function run(Environment $env, stdClass $value);

    /**
     * @param Environment $env
     * @param $value
     * @return boolean
     */
    public function verify(Environment $env, stdClass $value);

    /**
     * @return string
     */
    public function term();
}