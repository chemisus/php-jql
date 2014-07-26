<?php

class ParameterTerm implements Term
{
    private $name;
    private $prefix;
    private $suffix;

    public function __construct($name, $prefix = ':', $suffix = '')
    {
        $this->name = $name;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }

    public function toSql()
    {
        return $this->prefix . $this->name . $this->suffix;
    }
}