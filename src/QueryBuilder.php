<?php

class QueryBuilder
{
    private $env;
    private $terms;

    public function __construct(Environment $env, TermAssembler $terms)
    {
        $this->env = $env;
        $this->terms = $terms;
    }

    public function query()
    {
        return new Query($this->env, $this->terms);
    }
}