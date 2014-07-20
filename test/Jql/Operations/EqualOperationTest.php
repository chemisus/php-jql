<?php

namespace Jql\Operations;

use Mockery;
use TestCase;

class EqualOperationTest extends TestCase
{
    /**
     * @var EqualOperation
     */
    private $operation;

    /**
     * @var Operation
     */
    private $lhs;

    /**
     * @var Operation
     */
    private $rhs;

    /**
     * @var Environment
     */
    private $environment;

    public function setUp()
    {
        parent::setUp();

        $this->environment = Mockery::mock('Jql\Environment');

        $this->lhs = Mockery::mock('Jql\Operation');
        $this->rhs = Mockery::mock('Jql\Operation');

        $this->operation = new EqualOperation($this->lhs, $this->rhs);
    }

    public function testRunTrue()
    {
        $this->lhs->shouldReceive('run')->once()->with($this->environment)->andReturn(true);
        $this->rhs->shouldReceive('run')->once()->with($this->environment)->andReturn(true);

        $this->assertTrue($this->operation->run($this->environment));
    }

    public function testRunFalse()
    {
        $this->lhs->shouldReceive('run')->once()->with($this->environment)->andReturn(true);
        $this->rhs->shouldReceive('run')->once()->with($this->environment)->andReturn(false);

        $this->assertFalse($this->operation->run($this->environment));
    }
}
