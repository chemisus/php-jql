<?php

/**
 * Class Query
 *
 * @method or($value)
 */
class Query
{
    private $env;
    private $term_builder;
    private $or;
    private $and;

    public function __construct(Environemnt $env, TermBuilder $term_builder)
    {
        $this->env = $env;
        $this->term_builder = $term_builder;
        $this->or[] = array();
    }

    public function ands($value)
    {
        $this->and[] = $value;
    }

    public function ors($value)
    {
        $this->and = array($value);
        $this->or[] = $this->and;
    }

    public function __call($method, $parameters)
    {

    }
}