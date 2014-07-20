<?php

namespace Jql;

use Mockery;
use stdClass;
use TestCase;

class AbstractContainerOperationTest extends TestCase
{
    /**
     * @var Mockery\MockInterface
     */
    private $operation;

    /**
     * @var Mockery\MockInterface
     */
    private $values;

    /**
     * @var Environment
     */
    private $environment;

    public function setUp()
    {
        parent::setUp();

        $this->values = Mockery::mock('Jql\OperationContainer');
        $this->environment = Mockery::mock('Jql\Environment');
        $this->operation = Mockery::mock('Jql\AbstractContainerOperation', array('test', $this->values));
    }

    public function testFillJsonObject()
    {
        $object = new stdClass();

        $toJson_result = new stdClass();

        $this->values->shouldReceive('toJson')->once()->andReturn($toJson_result);
        $this->operation->shouldDeferMissing();

        $this->operation->fillJsonObject($object);

        $this->assertCount(1, (array)$object);
        $this->assertEquals($toJson_result, $object->values);
    }

    public function testValues()
    {
        $this->operation->shouldDeferMissing();

        $this->assertEquals($this->values, $this->operation->values());
    }
}