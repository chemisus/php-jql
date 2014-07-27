<?php

abstract class AbstractUnaryOperation extends AbstractTerm
{
    public function run(Environment $env, $term)
    {
        return $this->operate($env, $env->run($env->get($term, 'v')));
    }

    public abstract function operate(Environment $env, $term);

    public function verifyFields(Environment $env, $term)
    {
        return
            $env->has($term, 'v') &&
            $this->verifyValue($env, $env->get($term, 'v'));
    }

    public function verifyValue(Environment $env, $term)
    {
        return $env->verify($term);
    }
}