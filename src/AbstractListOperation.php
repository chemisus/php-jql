<?php

abstract class AbstractListOperation extends AbstractTerm
{
    /**
     * @param Environment $env
     * @param $term
     * @return bool
     */
    public function verifyFields(Environment $env, $term)
    {
        foreach ($env->get($term, 'v') as $term) {
            if (!$env->verify($term)) {
                return false;
            }
        }

        return true;
    }
}