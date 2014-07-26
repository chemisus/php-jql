<?php

class ValueTerm implements Term
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function toSql()
    {
        return (string)$this->value;
    }
}