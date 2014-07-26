<?php

abstract class AbstractEnvironment implements Environment
{
    private $operations;

    public function __construct($operations = array())
    {
        foreach ($operations as $value) {
            $this->operations[$value->term()] = $value;
        }
    }

    public function term(stdClass $value)
    {
        if (!isset($value->t)) {
            throw new Exception('no name specified.');
        }

        return $value->t;
    }

    public function verify(stdClass $value)
    {
        return
            isset($this->operations[$this->term($value)]) &&
            $this->operations[$this->term($value)]->verify($this, $value);
    }

    public function run(stdClass $value)
    {
        if (!$this->verify($value)) {
            throw new Exception($this->term($value) . ' verification failed');
        }

        return $this->operations[$this->term($value)]->run($this, $value);
    }
}