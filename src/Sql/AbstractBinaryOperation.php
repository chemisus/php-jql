<?php

namespace Sql;

use stdClass;

abstract class AbstractBinaryOperation extends AbstractOperation
{
    /**
     * @var \Sql\Operation
     */
    private $a;

    /**
     * @var \Sql\Operation
     */
    private $b;

    /**
     * @var string
     */
    private $key_a;

    /**
     * @var string
     */
    private $key_b;

    /**
     * @param string $op
     * @param Operation $a
     * @param Operation $b
     * @param string $key_a
     * @param string $key_b
     */
    public function __construct($op, Operation $a, Operation $b, $key_a = 'lhs', $key_b = 'rhs')
    {
        parent::__construct($op);

        $this->a = $a;
        $this->b = $b;
        $this->key_a = $key_a;
        $this->key_b = $key_b;
    }

    public function fillJsonObject(stdClass $object)
    {
        $object->{$this->key_a} = $this->a->toJson();
        $object->{$this->key_b} = $this->b->toJson();
    }

    /**
     * @return Operation
     */
    public function a()
    {
        return $this->a;
    }

    /**
     * @return Operation
     */
    public function b()
    {
        return $this->b;
    }
}