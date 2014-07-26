<?php

namespace Sql;

use AbstractTerm;
use Environment;


class SqlSelectOperation extends AbstractTerm
{
    public function __construct()
    {
        parent::__construct('select');
    }

    /**
     * @param Environment $env
     * @param $term
     * @return bool
     */
    public function verifyFields(Environment $env, $term)
    {
        return true;
//            $this->verifyKey($env, $term, 'f', false) &&
//            $this->verifyKey($env, $term, 'j', false) &&
//            $this->verifyKey($env, $term, 'w', false) &&
//            $this->verifyKey($env, $term, 'g', false) &&
//            $this->verifyKey($env, $term, 'v') &&
//            $this->verifyKey($env, $term, 'h', false) &&
//            $this->verifyKey($env, $term, 'o', false) &&
//            $this->verifyKey($env, $term, 's', false) &&
//            $this->verifyKey($env, $term, 'l', false);
    }

    /**
     * @param Environment $env
     * @param \ $term
     * @return mixed
     */
    public function run(Environment $env, $term)
    {
        $sql = 'select';
        $sql .= $this->value($env, $term);
        $sql .= $this->from($env, $term);
        $sql .= $this->join($env, $term);
        $sql .= $this->where($env, $term);
        $sql .= $this->group($env, $term);
        $sql .= $this->having($env, $term);
        $sql .= $this->order($env, $term);
        $sql .= $this->limit($env, $term);
        $sql .= $this->skip($env, $term);
        return $sql;
    }

    public function from(Environment $env, $term)
    {
        $key = 'f';

        if (!$env->has($term, $key)) {
            return '';
        }

        return ' ' . implode(' ', array_map(function ($term) use ($env) {
            return $env->run($term);
        }, $env->get($term, $key)));
    }

    public function join(Environment $env, $term)
    {
        $key = 'j';

        if (!$env->has($term, $key)) {
            return '';
        }

        return implode(', ', array_map(function ($term) use ($env) {
            return $env->run($term);
        }, $env->get($term, $key)));
    }

    public function where(Environment $env, $term)
    {
        $key = 'w';

        if (!$env->has($term, $key)) {
            return '';
        }

        return ' where ' . $env->run($env->get($term, $key));
    }

    public function group(Environment $env, $term)
    {
        $key = 'g';

        if (!$env->has($term, $key)) {
            return '';
        }

        return ' group by ' . implode(', ', array_map(function ($term) use ($env) {
            return $env->run($term);
        }, $env->get($term, $key)));
    }

    public function value(Environment $env, $term)
    {
        $key = 'v';

        if (!$env->has($term, $key)) {
            return '';
        }

        return ' ' . implode(', ', array_map(function ($term) use ($env) {
            return $env->run($term);
        }, $env->get($term, $key)));
    }

    public function having(Environment $env, $term)
    {
        $key = 'h';

        if (!$env->has($term, $key)) {
            return '';
        }

        return ' having ' . $env->run($env->get($term, $key));
    }

    public function order(Environment $env, $term)
    {
        $key = 'o';

        if (!$env->has($term, $key)) {
            return '';
        }

        return ' order by ' . implode(', ', array_map(function ($term) use ($env) {
            return $env->run($term);
        }, $env->get($term, $key)));
    }

    public function skip(Environment $env, $term)
    {
        $key = 's';

        if (!$env->has($term, $key)) {
            return '';
        }

        return ' offset ' . $env->run($env->get($term, $key));
    }

    public function limit(Environment $env, $term)
    {
        $key = 'l';

        if (!$env->has($term, $key)) {
            return '';
        }

        return ' limit ' . $env->run($env->get($term, $key));
    }
}