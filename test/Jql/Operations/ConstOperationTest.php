<?php

namespace Jql\Operations;

use Jql\Environment;
use Jql\Operation;
use Mockery;
use TestCase;

class ConstOperationTest extends TestCase
{
    /**
     * @var ConstOperation
     */
    private $operation;

    /**
     * @var Mockery\MockInterface
     */
    private $value;

    /**
     * @var Environment
     */
    private $environment;

    public function setUp()
    {
        parent::setUp();

        $this->environment = Mockery::mock('Jql\Environment');
        $this->value = Mockery::mock();
        $this->operation = new ConstOperation($this->value);
    }

    public function testFillJsonObject()
    {
        $object = new \stdClass();

        $this->operation->fillJsonObject($object);

        $this->assertCount(1, (array)$object);
        $this->assertEquals($this->value, $object->value);
    }

    public function testValue()
    {
        $this->assertEquals($this->value, $this->operation->value());
    }

    public function testRun()
    {
        $this->assertEquals($this->value, $this->operation->run($this->environment));
    }
}
