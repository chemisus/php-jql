<?php

namespace Jql;

use AbstractTerm;
use Environment;

class JqlSelectOperation extends AbstractTerm
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
        $rows = $this->from($env, $term);
        $rows = $this->join($env, $term, $rows);
        $rows = $this->where($env, $term, $rows);
        $rows = $this->group($env, $term, $rows);
        $rows = $this->value($env, $term, $rows);
        $rows = $this->having($env, $term, $rows);
        $rows = $this->order($env, $term, $rows);
        $rows = $this->skip($env, $term, $rows);
        $rows = $this->limit($env, $term, $rows);

        return $rows;
    }

    public function from(Environment $env, $terms)
    {
        $key = 'f';

        $results = array();

        foreach ($env->get($terms, $key) as $term) {
            foreach ($env->run($term) as $table => $rows) {
                if (!count($results)) {
                    foreach ($rows as $id => $row) {
                        $results[] = array($table => $row);
                    }
                } else {
                    $rs = array();
                    foreach ($results as $result) {
                        foreach ($rows as $id => $row) {
                            $rs[] = array_merge(array($table => $row), $result);
                        }
                    }
                    $results = $rs;
                }
            }
        }

        return $results;
    }

    public function join(Environment $env, $term, array $rows = array())
    {
        return $rows;
    }

    public function where(Environment $env, $term, array $rows = array())
    {
        $key = 'w';

        if (!$env->has($term, $key)) {
            return $rows;
        }

        $results = array_filter($rows, function ($row) use ($env, $term, $key) {
            $env->push($row);

            $result = $env->run($env->get($term, $key));

            $env->pop();

            return $result;
        });

        return $results;
    }

    public function group(Environment $env, $term, array $rows = array())
    {
        return $rows;
    }

    public function value(Environment $env, $terms, array $rows = array())
    {
        $key = 'v';

        $results = array();

        foreach ($rows as $row) {
            $env->push($row);

            $result = array();

            foreach ($env->get($terms, $key) as $term) {
                $result = array_merge($result, $env->run($term));
            }

            $env->pop();

            $results[] = $result;
        }

        return $results;
    }

    public function having(Environment $env, $terms, array $rows = array())
    {
        return $rows;
    }

    public function order(Environment $env, $terms, array $rows = array())
    {
        return $rows;
    }

    public function skip(Environment $env, $term, array $rows = array())
    {
        $key = 's';

        if (!$env->has($term, $key)) {
            return $rows;
        }

        return array_slice($rows, $env->run($env->get($term, $key)));
    }

    public function limit(Environment $env, $term, array $rows = array())
    {
        $key = 'l';

        if (!$env->has($term, $key)) {
            return $rows;
        }

        return array_slice($rows, 0, $env->run($env->get($term, $key)));
    }
}