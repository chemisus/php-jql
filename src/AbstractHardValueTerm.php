<?php

abstract class AbstractHardValueTerm extends AbstractTerm
{
    private $value;

    public function __construct($name, $value)
    {
        parent::__construct($name);

        $this->value = $value;
    }

    /**
     * @param Environment $env
     * @param  $term
     * @return mixed
     */
    public function run(Environment $env, $term)
    {
        return $this->value;
    }

    public function verifyFields(Environment $env, $term)
    {
        return true;
    }
}