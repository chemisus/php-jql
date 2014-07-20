<?php

namespace Jql;

use Mockery;
use stdClass;
use TestCase;

class AbstractBinaryOperationTest extends TestCase
{
    /**
     * @var Mockery\MockInterface
     */
    private $operation;

    /**
     * @var Mockery\MockInterface
     */
    private $lhs;

    /**
     * @var Mockery\MockInterface
     */
    private $rhs;

    /**
     * @var Environment
     */
    private $environment;

    public function setUp()
    {
        parent::setUp();

        $this->lhs = Mockery::mock('Jql\Operation');
        $this->rhs = Mockery::mock('Jql\Operation');
        $this->environment = Mockery::mock('Jql\Environment');
        $this->operation = Mockery::mock('Jql\AbstractBinaryOperation', array('test', $this->lhs, $this->rhs));
    }

    public function testLhs()
    {
        $this->operation->shouldDeferMissing();

        $this->assertEquals($this->lhs, $this->operation->lhs());
    }

    public function testRhs()
    {
        $this->operation->shouldDeferMissing();

        $this->assertEquals($this->rhs, $this->operation->rhs());
    }

    public function testFillJsonObject()
    {
        $object = new stdClass();

        $lhs_result = new stdClass();
        $rhs_result = new stdClass();

        $this->lhs->shouldReceive('toJson')->once()->andReturn($lhs_result);
        $this->rhs->shouldReceive('toJson')->once()->andReturn($rhs_result);
        $this->operation->shouldDeferMissing();

        $this->operation->fillJsonObject($object);

        $this->assertCount(2, (array)$object);
        $this->assertEquals($lhs_result, $object->lhs);
        $this->assertEquals($rhs_result, $object->rhs);
    }
}