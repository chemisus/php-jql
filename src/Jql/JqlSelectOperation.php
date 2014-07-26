<?php

namespace Jql;

use AbstractTerm;
use Environment;
use stdClass;

class JqlSelectOperation extends AbstractTerm
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
        $rows = $this->from($env, $value);
        $rows = $this->join($env, $value, $rows);
        $rows = $this->where($env, $value, $rows);
        $rows = $this->group($env, $value, $rows);
        $rows = $this->value($env, $value, $rows);
        $rows = $this->having($env, $value, $rows);
        $rows = $this->order($env, $value, $rows);
        $rows = $this->skip($env, $value, $rows);
        $rows = $this->limit($env, $value, $rows);
        return $rows;
    }

    public function flatten($table, $row)
    {
        $result = array();

        foreach ($row as $key => $value) {
            $result[$table . '.' . $key] = $value;
        }

        return $result;
    }

    public function from(Environment $env, stdClass $ops)
    {
        $key = 'f';

        $results = array();

        foreach ($ops->{$key} as $op) {
            foreach ($env->run($op) as $table => $rows) {
                if (!count($results)) {
                    foreach ($rows as $id => $row) {
                        $results[] = $this->flatten($table, $row);
                    }
                } else {
                    $rs = array();
                    foreach ($results as $result) {
                        foreach ($rows as $id => $row) {
                            $rs[] = array_merge($this->flatten($table, $row), $result);
                        }
                    }
                    $results = $rs;
                }
            }
        }

//        $result = array_reduce(array_map(function ($op) use ($env) {
//            return $env->run($op);
//        }, $value->{$key}), function ($initial, $current) {
//            if ($initial === null) {
//                return $current;
//            }
//
//
//        }, null);

        return $results;
    }

    public function join(Environment $env, stdClass $value, array $rows = array())
    {
        return $rows;
    }

    public function where(Environment $env, stdClass $where, array $rows = array())
    {
        $key = 'w';

        if (!isset($where->{$key})) {
            return $rows;
        }

        $results = array_filter($rows, function ($row) use ($env, $where, $key) {
            $env->push($row);

            $result = $env->run($where->{$key});

            $env->pop();

            return $result;
        });

        return $results;
    }

    public function group(Environment $env, stdClass $value, array $rows = array())
    {
        return $rows;
    }

    public function value(Environment $env, stdClass $ops, array $rows = array())
    {
        $key = 'v';

        $results = array();

        foreach ($rows as $row) {
            $env->push($row);

            $result = array();

            foreach ($ops->{$key} as $op) {
                $result = array_merge($result, $env->run($op));
            }

            $env->pop();

            $results[] = $result;
        }

        return $results;
    }

    public function having(Environment $env, stdClass $value, array $rows = array())
    {
        return $rows;
    }

    public function order(Environment $env, stdClass $value, array $rows = array())
    {
        return $rows;
    }

    public function skip(Environment $env, stdClass $value, array $rows = array())
    {
        return $rows;
    }

    public function limit(Environment $env, stdClass $value, array $rows = array())
    {
        return $rows;
    }
}