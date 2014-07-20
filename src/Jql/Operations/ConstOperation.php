<?php

namespace Jql\Operations;

use Jql\AbstractOperation;
use Jql\Environment;
use Jql\Operation;
use stdClass;

class ConstOperation extends AbstractOperation
{
    private $value;

    public function __construct($value)
    {
        parent::__construct('const');

        $this->value = $value;
    }

    public function run(Environment $environment)
    {
        return $this->value();
    }

    public function fillJsonObject(stdClass $object)
    {
        $object->value = $this->value;
    }

    /**
     * @return Operation
     */
    public function value()
    {
        return $this->value;
    }
}