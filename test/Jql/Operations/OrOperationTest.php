<?php

namespace Jql\Operations;

use ArrayIterator;
use Jql\Environment;
use Mockery;
use stdClass;
use TestCase;

class OrOperationTest extends TestCase
{
    /**
     * @var OrOperation
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
        $this->operation = new OrOperation($this->values);
    }

    public function testOp()
    {
        $this->assertEquals('or', $this->operation->op());
    }

    /**
     * @dataProvider runTrueProvider
     */
    public function testRunTrue($true, $false, $values, $count)
    {
        $false->shouldReceive('run')->times($count);
        $true->shouldReceive('run')->andReturn(true);

        $this->values->shouldReceive('getIterator')->once()->andReturn(new ArrayIterator($values));

        $this->assertTrue($this->operation->run($this->environment));
    }

    /**
     * @dataProvider runFalseProvider
     */
    public function testRunFalse($true, $false, $values, $count)
    {
        $false->shouldReceive('run')->times($count);
        $true->shouldReceive('run')->andReturn(true);

        $this->values->shouldReceive('getIterator')->once()->andReturn(new ArrayIterator($values));

        $this->assertFalse($this->operation->run($this->environment));
    }

    public function runTrueProvider()
    {
        $true = Mockery::mock('Jql\Operation');
        $false = Mockery::mock('Jql\Operation');

        return array(
            array($true, $false, array($true), 0),
            array($true, $false, array($false, $true), 1),
            array($true, $false, array($true, $false, $false), 0),
            array($true, $false, array($false, $true, $false), 1),
            array($true, $false, array($false, $false, $true), 2),
        );
    }

    public function runFalseProvider()
    {
        $true = Mockery::mock('Jql\Operation');
        $false = Mockery::mock('Jql\Operation');

        return array(
            array($true, $false, array(), 0),
            array($true, $false, array($false), 1),
            array($true, $false, array($false, $false), 2),
        );
    }
}
