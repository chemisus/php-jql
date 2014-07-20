<?php

namespace Jql\Operations;

use Jql\Environment;
use Mockery;
use TestCase;

class FalseOperationTest extends TestCase
{
    /**
     * @var FalseOperation
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

        $this->operation = new FalseOperation();
    }

    public function testRun()
    {
        $this->assertFalse($this->operation->run($this->environment));
    }
}
