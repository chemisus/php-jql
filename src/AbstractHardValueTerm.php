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
     * @param stdClass $value
     * @return mixed
     */
    public function run(Environment $env, stdClass $value)
    {
        return $this->value;
    }

    public function verifyFields(Environment $env, stdClass $value)
    {
        return true;
    }
}