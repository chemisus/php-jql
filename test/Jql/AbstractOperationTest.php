<?php

namespace Jql;

use Mockery;
use stdClass;
use TestCase;

class AbstractOperationTest extends TestCase
{
    /**
     * @var Mockery\MockInterface
     */
    private $operation;

    /**
     * @var Environment
     */
    private $environment;

    public function setUp()
    {
        parent::setUp();

        $this->environment = Mockery::mock('Jql\Environment');
        $this->operation = Mockery::mock('Jql\AbstractOperation', array('test'));
    }

    public function testOp()
    {
        $this->operation->shouldDeferMissing();

        $this->assertEquals('test', $this->operation->op());
    }

    public function testNewJsonObject()
    {
        $this->operation->shouldDeferMissing();

        $object = $this->operation->newJsonObject();
        $this->assertInstanceOf('stdClass', $object);
        $this->assertCount(0, (array)$object);
    }

    public function testToJson()
    {
        $op = 'test';
        $object = new stdClass();

        $this->operation->shouldReceive('newJsonObject')->once()->andReturn($object);
        $this->operation->shouldReceive('fillJsonObject')->once()->with($object);
        $this->operation->shouldDeferMissing();

        $actual = $this->operation->toJson();

        $this->assertEquals($object, $actual);
        $this->assertCount(1, (array)$actual);
        $this->assertEquals($op, $actual->op);
    }

    public function testFillJsonObject()
    {
        $object = new stdClass();

        $this->operation->shouldDeferMissing();

        $actual = $this->operation->fillJsonObject($object);

        $this->assertNull($actual);
        $this->assertCount(0, (array)$actual);
    }
}