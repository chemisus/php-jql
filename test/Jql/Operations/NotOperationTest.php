<?php

namespace Jql\Operations;

use Jql\Environment;
use Jql\Operation;
use Mockery;
use TestCase;

class NotOperationTest extends TestCase
{
    /**
     * @var NotOperation
     */
    private $operation;

    /**
     * @var Operation
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

        $this->value = Mockery::mock('Jql\Operation');

        $this->operation = new NotOperation($this->value);
    }

    public function testRunTrueTurnsFalse()
    {
        $this->value->shouldReceive('run')->once()->with($this->environment)->andReturn(true);

        $this->assertFalse($this->operation->run($this->environment));
    }

    public function testRunFalseTurnsTrue()
    {
        $this->value->shouldReceive('run')->once()->with($this->environment)->andReturn(false);

        $this->assertTrue($this->operation->run($this->environment));
    }
}
