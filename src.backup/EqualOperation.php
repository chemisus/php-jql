<?php

class EqualOperation implements Term
{
    private $a;
    private $b;

    public function __construct(Term $a, Term $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function toSql()
    {
        return $this->a->toSql() . '=' . $this->b->toSql();
    }
}