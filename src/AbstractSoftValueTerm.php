<?php

abstract class AbstractSoftValueTerm extends AbstractTerm
{
    public function __construct($name)
    {
        parent::__construct($name);
    }

    /**
     * @param Environment $env
     * @param  $term
     * @return mixed
     */
    public function run(Environment $env, $term)
    {
        return $this->operate($env, $env->get($term, 'v'));
    }

    public function verifyFields(Environment $env, $term)
    {
        return true;
    }

    public abstract function operate(Environment $env, $term);
}