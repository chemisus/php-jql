<?php

abstract class AbstractListOperation extends AbstractTerm
{
    /**
     * @param Environment $env
     * @param $value
     * @return bool
     */
    public function verifyFields(Environment $env, stdClass $value)
    {
        foreach ($value->v as $value) {
            if (!$env->verify($value)) {
                return false;
            }
        }

        return true;
    }
}