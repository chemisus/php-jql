<?php

abstract class AbstractTerm implements Term
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function term()
    {
        return $this->term;
    }

    /**
     * @param Environment $env
     * @param $value
     * @return boolean
     */
    public function verify(Environment $env, stdClass $value)
    {
        if ($this->term() !== $env->term($value)) {
            return false;
        }

        return $this->verifyFields($env, $value);
    }

    public function verifyKey(Environment $env, stdClass $value, $key, $required = true)
    {
        if ($required && !isset($value->{$key})) {
            return false;
        }

        return $env->verify($value->{$key});
    }

    /**
     * @param Environment $env
     * @param $value
     * @return bool
     */
    public abstract function verifyFields(Environment $env, stdClass $value);
}