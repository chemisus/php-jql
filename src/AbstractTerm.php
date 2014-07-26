<?php

abstract class AbstractTerm implements Term
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function name()
    {
        return $this->term;
    }

    /**
     * @param Environment $env
     * @param $term
     * @return boolean
     */
    public function verify(Environment $env, $term)
    {
        if ($this->name() !== $env->name($term)) {
            return false;
        }

        return $this->verifyFields($env, $term);
    }

    public function verifyKey(Environment $env, $term, $key, $required = true)
    {
        if ($required && !$env->has($term, $key)) {
            return false;
        }

        return $env->verify($env->get($term, $key));
    }

    /**
     * @param Environment $env
     * @param $term
     * @return bool
     */
    public abstract function verifyFields(Environment $env, $term);
}