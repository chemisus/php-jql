<?php

namespace Jql;

use AbstractTerm;
use Environment;

class JqlFromOperation extends AbstractTerm
{
    public function __construct()
    {
        parent::__construct('from');
    }

    public function operate(Environment $env, $term)
    {
        return !$term;
    }

    /**
     * @param Environment $env
     * @param $term
     * @return bool
     */
    public function verifyFields(Environment $env, $term)
    {
        return true;
    }

    /**
     * @param Environment $env
     * @param  $term
     * @return mixed
     */
    public function run(Environment $env, $term)
    {
        $results = array();

        foreach ($env->run($env->get($term, 'v')) as $table => $rows) {
            $results = array_merge($results, array_map(function ($row) use ($table) {
                return array($table => $row);
            }, $rows));
        }

        return $results;
    }
}