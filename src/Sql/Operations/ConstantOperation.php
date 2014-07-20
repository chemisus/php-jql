<?php

namespace Sql\Operations;

use Sql\AbstractOperation;
use Sql\Environment;
use Sql\Operation;
use stdClass;

class ConstantOperation extends AbstractOperation
{
    private $value;

    public function __construct($value)
    {
        parent::__construct('const');

        $this->value = $value;
    }

    public function run(Environment $environment)
    {
        return json_encode($this->value());
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