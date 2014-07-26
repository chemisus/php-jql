<?php

abstract class AbstractUnaryOperation extends AbstractTerm
{
    public final function run(Environment $env, $term)
    {
        return $this->operate($env->run($env->get($term, 'v')));
    }

    public abstract function operate($term);

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