<?php

abstract class AbstractBinaryOperation extends AbstractTerm
{
    public final function run(Environment $env, stdClass $value)
    {
        return $this->operate($env->run($value->a), $env->run($value->b));
    }

    public abstract function operate($a, $b);

    public function verifyFields(Environment $env, stdClass $value)
    {
        return
            isset($value->a) &&
            isset($value->b) &&
            $this->verifyA($env, $value->a) &&
            $this->verifyB($env, $value->b);
    }

    public function verifyA(Environment $env, $value)
    {
        return $env->verify($value);
    }

    public function verifyB(Environment $env, $value)
    {
        return $env->verify($value);
    }
}