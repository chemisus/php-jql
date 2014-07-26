<?php

abstract class AbstractSoftValueTerm extends AbstractTerm
{
    public function __construct($name)
    {
        parent::__construct($name);
    }

    /**
     * @param Environment $env
     * @param stdClass $value
     * @return mixed
     */
    public function run(Environment $env, stdClass $value)
    {
        return $this->operate($env, $value->v);
    }

    public function verifyFields(Environment $env, stdClass $value)
    {
        return true;
    }

    public abstract function operate(Environment $env, $value);
}