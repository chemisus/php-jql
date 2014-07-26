<?php

class TermContainer extends Container implements Term
{
    private $glue;

    private $prefix;

    private $suffix;

    public function __construct(array $terms = array(), $glue = ',', $prefix = '', $suffix = '')
    {
        parent::__construct($terms, array('Term'));

        $this->glue = $glue;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }

    public function toSql()
    {
        return
            $this->prefix .
            $this->each('toSql', array(), 'string')->implode($this->glue) .
            $this->suffix;
    }
}