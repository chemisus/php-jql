<?php

abstract class AbstractUnaryOperation extends AbstractTerm
{
    public final function run(Environment $env, stdClass $value)
    {
        return $this->operate($env->run($value->v));
    }

    public abstract function operate($value);

    public function verifyFields(Environment $env, stdClass $value)
    {
        return
            isset($value->v) &&
            $this->verifyValue($env, $value->v);
    }

    public function verifyValue(Environment $env, $value)
    {
        return $env->verify($value);
    }
}