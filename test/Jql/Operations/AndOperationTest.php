<?php

namespace Jql\Operations;

use ArrayIterator;
use Jql\Environment;
use Mockery;
use TestCase;

class AndOperationTest extends TestCase
{
    /**
     * @var AndOperation
     */
    private $operation;

    /**
     * @var Mockery\MockInterface
     */
    private $values;

    /**
     * @var Mockery\MockInterface
     */
    private $iterator;

    /**
     * @var Environment
     */
    private $environment;

    public function setUp()
    {
        parent::setUp();

        $this->environment = Mockery::mock('Jql\Environment');
        $this->values = Mockery::mock('Jql\OperationContainer');
        $this->iterator = Mockery::mock('ArrayIterator');
        $this->operation = new AndOperation($this->values);

    }

    public function testOp()
    {
        $this->assertEquals('and', $this->operation->op());
    }

    /**
     * @dataProvider runTrueProvider
     */
    public function testRunTrue($true, $false, $values, $count)
    {
        $true->shouldReceive('run')->times($count)->andReturn(true);
        $false->shouldReceive('run')->never();

        $this->values->shouldReceive('getIterator')->once()->andReturn(new ArrayIterator($values));

        $this->assertTrue($this->operation->run($this->environment));
    }

    /**
     * @dataProvider runFalseProvider
     */
    public function testRunFalse($true, $false, $values, $count)
    {
        $true->shouldReceive('run')->times($count);
        $false->shouldReceive('run')->once()->andReturn(false);

        $this->values->shouldReceive('getIterator')->once()->andReturn(new ArrayIterator($values));

        $this->assertFalse($this->operation->run($this->environment));
    }

    public function runTrueProvider()
    {
        $true = Mockery::mock('Jql\Operation');
        $false = Mockery::mock('Jql\Operation');

        return array(
            array($true, $false, array(), 0),
            array($true, $false, array($true), 1),
            array($true, $false, array($true, $true), 2),
        );
    }

    public function runFalseProvider()
    {
        $true = Mockery::mock('Jql\Operation');
        $false = Mockery::mock('Jql\Operation');

        return array(
            array($true, $false, array($false), 0),
            array($true, $false, array($true, $false), 1),
            array($true, $false, array($false, $true, $true), 0),
            array($true, $false, array($true, $false, $true), 1),
            array($true, $false, array($true, $true, $false), 2),
        );
    }
}
