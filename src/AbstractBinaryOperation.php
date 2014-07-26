<?php

abstract class AbstractBinaryOperation extends AbstractTerm
{
    public final function run(Environment $env, $term)
    {
        return $this->operate($env->run($env->get($term, 'a')), $env->run($env->get($term, 'b')));
    }

    public abstract function operate($a, $b);

    public function verifyFields(Environment $env, $term)
    {
        return
            $env->has($term, 'a') &&
            $env->has($term, 'b') &&
            $this->verifyA($env, $env->get($term, 'a')) &&
            $this->verifyB($env, $env->get($term, 'b'));
    }

    public function verifyA(Environment $env, $term)
    {
        return $env->verify($term);
    }

    public function verifyB(Environment $env, $term)
    {
        return $env->verify($term);
    }
}