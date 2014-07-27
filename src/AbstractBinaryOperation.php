<?php

abstract class AbstractBinaryOperation extends AbstractTerm
{
    public function run(Environment $env, $term)
    {
        return $this->operate($env, $this->runA($env, $env->get($term, 'a')), $this->runB($env, $env->get($term, 'b')));
    }

    public abstract function operate(Environment $env, $a, $b);

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

    public function runA(Environment $env, $term) {
        return $env->run($term);
    }

    public function runB(Environment $env, $term) {
        return $env->run($term);
    }
}