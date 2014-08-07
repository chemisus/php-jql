<?php

class QueryBuilder
{
    private $reader;
    private $terms;

    public function __construct(TermReader $reader, TermAssembler $terms)
    {
        $this->reader = $reader;
        $this->terms = $terms;
    }

    public function query()
    {
        return new Query($this->reader, $this->terms);
    }
}