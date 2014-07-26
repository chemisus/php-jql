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

    public function select($v, $f = null, $w = null)
    {
        return $this->term_builder
            ->make('select')
            ->set('v', $v)
            ->set('f', $f, false)
            ->set('w', $w, false)
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
}