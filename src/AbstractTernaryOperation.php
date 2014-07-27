<?php

abstract class AbstractTernaryOperation extends AbstractTerm
{
    public final function run(Environment $env, $term)
    {
        return $this->operate(
            $env,
            $this->runA($env, $env->get($term, 'a')),
            $this->runB($env, $env->get($term, 'b')),
            $this->runB($env, $env->get($term, 'c'))
        );
    }

    public abstract function operate(Environment $env, $a, $b, $c);

    public function verifyFields(Environment $env, $term)
    {
        return
            $env->has($term, 'a') &&
            $env->has($term, 'b') &&
            $env->has($term, 'c') &&
            $this->verifyA($env, $env->get($term, 'a')) &&
            $this->verifyB($env, $env->get($term, 'b')) &&
            $this->verifyC($env, $env->get($term, 'c'));
    }

    public function verifyA(Environment $env, $term)
    {
        return $env->verify($term);
    }

    public function verifyB(Environment $env, $term)
    {
        return $env->verify($term);
    }

    public function verifyC(Environment $env, $term)
    {
        return $env->verify($term);
    }

    public function runA(Environment $env, $term) {
        return $env->run($term);
    }

    public function runB(Environment $env, $term) {
        return $env->run($term);
    }

    public function runC(Environment $env, $term) {
        return $env->run($term);
    }
}