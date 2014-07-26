<?php

class QueryBuilder
{
    public function true()
    {
        $term = new stdClass();
        $term->t = 'true';
        return $term;
    }

    public function false()
    {
        $term = new stdClass();
        $term->t = 'false';
        return $term;
    }

    public function eq(stdClass $a, stdClass $b)
    {
        $term = new stdClass();
        $term->t = 'equal';
        $term->a = $a;
        $term->b = $b;
        return $term;
    }

    public function not($value)
    {
        $term = new stdClass();
        $term->t = 'not';
        $term->v = $value;
        return $term;
    }

    public function ands(array $values = array())
    {
        $term = new stdClass();
        $term->t = 'and';
        $term->v = $values;
        return $term;
    }

    public function ors(array $values = array())
    {
        $term = new stdClass();
        $term->t = 'or';
        $term->v = $values;
        return $term;
    }

    public function select($v, $f = null, $w = null)
    {
        $term = new stdClass();
        $term->t = 'select';
        $term->v = $v;
        if ($f !== null) {
            $term->f = $f;
        }
        if ($w !== null) {
            $term->w = $w;
        }
        return $term;
    }

    public function entity($value)
    {
        $term = new stdClass();
        $term->t = 'entity';
        $term->v = $value;
        return $term;
    }

    public function param($value)
    {
        $term = new stdClass();
        $term->t = 'param';
        $term->v = $value;
        return $term;
    }

    public function table($value)
    {
        $term = new stdClass();
        $term->t = 'table';
        $term->v = $value;
        return $term;
    }

    public function field($value)
    {
        $term = new stdClass();
        $term->t = 'field';
        $term->v = $value;
        return $term;
    }
}