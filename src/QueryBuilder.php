<?php

class QueryBuilder
{
    private $env;
    private $term_builder;

    public function __construct(Environment $env, TermBuilder $term_builder)
    {
        $this->env = $env;
        $this->term_builder = $term_builder;
    }

    public function query()
    {
        return new Query($this->env, $this->term_builder);
    }
}