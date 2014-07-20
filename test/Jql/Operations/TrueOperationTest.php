<?php

namespace Jql\Operations;

use Jql\Environment;
use Mockery;
use TestCase;

class TrueOperationTest extends TestCase
{
    /**
     * @var TrueOperation
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
        $this->operation = new TrueOperation();;
    }

    public function testOp()
    {
        $this->assertEquals('true', $this->operation->op());
    }

    public function testRun()
    {
        $this->assertTrue($this->operation->run($this->environment));
    }
}
