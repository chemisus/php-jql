<?php

class QueryBuilder
{
    /**
     * @var TermBuilder
     */
    private $term_builder;

    /**
     * @param TermBuilder $term_builder
     */
    public function __construct(TermBuilder $term_builder)
    {
        $this->term_builder = $term_builder;
    }

    public function true()
    {
        return $this->term_builder->make('true')->build();
    }

    public function false()
    {
        return $this->term_builder->make('false')->build();
    }

    public function eq($a, $b)
    {
        return $this->term_builder
            ->make('equal')
            ->set('a', $a)
            ->set('b', $b)
            ->build();
    }

    public function gt($a, $b)
    {
        return $this->term_builder
            ->make('gt')
            ->set('a', $a)
            ->set('b', $b)
            ->build();
    }

    public function lt($a, $b)
    {
        return $this->term_builder
            ->make('lt')
            ->set('a', $a)
            ->set('b', $b)
            ->build();
    }

    public function not($term)
    {
        return $this->term_builder
            ->make('not')
            ->set('v', $term)
            ->build();
    }

    public function ands(array $terms = array())
    {
        return $this->term_builder
            ->make('and')
            ->set('v', $terms)
            ->build();
    }

    public function ors(array $terms = array())
    {
        return $this->term_builder
            ->make('or')
            ->set('v', $terms)
            ->build();
    }

    public function select($v = null, $f = null, $j = null, $w = null, $g = null, $h = null, $o = null, $l = null, $s = null)
    {
        return $this->term_builder
            ->make('select')
            ->set('v', $v)
            ->set('f', $f, false)
            ->set('j', $j, false)
            ->set('w', $w, false)
            ->set('g', $g, false)
            ->set('h', $h, false)
            ->set('o', $o, false)
            ->set('l', $l, false)
            ->set('s', $s, false)
            ->build();
    }

    public function entity($value)
    {
        return $this->term_builder
            ->make('entity')
            ->set('v', $value)
            ->build();
    }

    public function param($value)
    {
        return $this->term_builder
            ->make('param')
            ->set('v', $value)
            ->build();
    }

    public function table($value)
    {
        return $this->term_builder
            ->make('table')
            ->set('v', $value)
            ->build();
    }

    public function field($value)
    {
        return $this->term_builder
            ->make('field')
            ->set('v', $value)
            ->build();
    }

    public function alias($a, $b)
    {
        return $this->term_builder
            ->make('alias')
            ->set('a', $a)
            ->set('b', $b)
            ->build();
    }

    public function subquery($a, $b)
    {
        return $this->term_builder
            ->make('sq')
            ->set('a', $a)
            ->set('b', $b)
            ->build();
    }

    public function leftJoin($a, $b)
    {
        return $this->term_builder
            ->make('lj')
            ->set('a', $a)
            ->set('b', $b)
            ->build();
    }

    public function rightJoin($a, $b)
    {
        return $this->term_builder
            ->make('rj')
            ->set('a', $a)
            ->set('b', $b)
            ->build();
    }
}