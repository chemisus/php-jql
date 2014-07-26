<?php

namespace Sql;

use AbstractTerm;
use Environment;
use stdClass;

class SqlSelectOperation extends AbstractTerm
{
    public function __construct()
    {
        parent::__construct('select');
    }

    /**
     * @param Environment $env
     * @param $value
     * @return bool
     */
    public function verifyFields(Environment $env, stdClass $value)
    {
        return true;
//            $this->verifyKey($env, $value, 'f', false) &&
//            $this->verifyKey($env, $value, 'j', false) &&
//            $this->verifyKey($env, $value, 'w', false) &&
//            $this->verifyKey($env, $value, 'g', false) &&
//            $this->verifyKey($env, $value, 'v') &&
//            $this->verifyKey($env, $value, 'h', false) &&
//            $this->verifyKey($env, $value, 'o', false) &&
//            $this->verifyKey($env, $value, 's', false) &&
//            $this->verifyKey($env, $value, 'l', false);
    }

    /**
     * @param Environment $env
     * @param \stdClass $value
     * @return mixed
     */
    public function run(Environment $env, stdClass $value)
    {
        $sql = 'select';
        $sql .= $this->value($env, $value);
        $sql .= $this->from($env, $value);
        $sql .= $this->join($env, $value);
        $sql .= $this->where($env, $value);
        $sql .= $this->group($env, $value);
        $sql .= $this->having($env, $value);
        $sql .= $this->order($env, $value);
        $sql .= $this->limit($env, $value);
        $sql .= $this->skip($env, $value);
        return $sql;
    }

    public function from(Environment $env, stdClass $value)
    {
        $key = 'f';

        if (!isset($value->{$key})) {
            return '';
        }

        return ' from ' . implode(', ', array_map(function ($value) use ($env) {
            return $env->run($value);
        }, $value->{$key}));
    }

    public function join(Environment $env, stdClass $value)
    {
        $key = 'j';

        if (!isset($value->{$key})) {
            return '';
        }

        return implode(', ', array_map(function ($value) use ($env) {
            return $env->run($value);
        }, $value->{$key}));
    }

    public function where(Environment $env, stdClass $value)
    {
        $key = 'w';

        if (!isset($value->{$key})) {
            return '';
        }

        return ' where ' . $env->run($value->{$key});
    }

    public function group(Environment $env, stdClass $value)
    {
        $key = 'g';

        if (!isset($value->{$key})) {
            return '';
        }

        return ' group by ' . implode(', ', array_map(function ($value) use ($env) {
            return $env->run($value);
        }, $value->{$key}));
    }

    public function value(Environment $env, stdClass $value)
    {
        $key = 'v';

        if (!isset($value->{$key})) {
            return '';
        }

        return ' ' . implode(', ', array_map(function ($value) use ($env) {
            return $env->run($value);
        }, $value->{$key}));
    }

    public function having(Environment $env, stdClass $value)
    {
        $key = 'h';

        if (!isset($value->{$key})) {
            return '';
        }

        return ' having ' . $env->run($value->{$key});
    }

    public function order(Environment $env, stdClass $value)
    {
        $key = 'o';

        if (!isset($value->{$key})) {
            return '';
        }

        return ' order by ' . implode(', ', array_map(function ($value) use ($env) {
            return $env->run($value);
        }, $value->{$key}));
    }

    public function skip(Environment $env, stdClass $value)
    {
        $key = 's';

        if (!isset($value->{$key})) {
            return '';
        }

        return ' offset ' . $env->run($value->{$key});
    }

    public function limit(Environment $env, stdClass $value)
    {
        $key = 'l';

        if (!isset($value->{$key})) {
            return '';
        }

        return ' limit ' . $env->run($value->{$key});
    }
}