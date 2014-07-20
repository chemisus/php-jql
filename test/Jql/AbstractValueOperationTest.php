<?php

namespace Jql;

use Mockery;
use stdClass;
use TestCase;

class AbstractValueOperationTest extends TestCase
{
    /**
     * @var Mockery\MockInterface
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

        $this->value = Mockery::mock('Jql\Operation');
        $this->environment = Mockery::mock('Jql\Environment');
        $this->operation = Mockery::mock('Jql\AbstractValueOperation', array('test', $this->value));
    }

    public function testFillJsonObject()
    {
        $object = new stdClass();

        $toJson_result = new stdClass();

        $this->value->shouldReceive('toJson')->once()->andReturn($toJson_result);
        $this->operation->shouldDeferMissing();

        $this->operation->fillJsonObject($object);

        $this->assertCount(1, (array)$object);
        $this->assertEquals($toJson_result, $object->value);
    }

    public function testValue()
    {
        $this->operation->shouldDeferMissing();

        $this->assertEquals($this->value, $this->operation->value());
    }
}