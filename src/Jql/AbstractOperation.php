<?php

namespace Jql;

use stdClass;

abstract class AbstractOperation implements Operation
{
    /**
     * @var string
     */
    private $op;

    /**
     * @param string $op
     */
    public function __construct($op)
    {
        $this->op = $op;
    }

    /**
     * @return string
     */
    public final function op()
    {
        return $this->op;
    }

    /**
     * @return mixed
     */
    public final function toJson()
    {
        $object = $this->newJsonObject();

        $object->op = $this->op();

        $this->fillJsonObject($object);

        return $object;
    }

    /**
     * @return stdClass
     */
    public function newJsonObject()
    {
        return new stdClass();
    }

    /**
     * @param stdClass $object
     * @return void
     */
    public function fillJsonObject(stdClass $object)
    {
    }
}